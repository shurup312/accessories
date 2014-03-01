<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 18.01.14
 * Time: 15:50
 */

/**
 * TODO: надо сделать удаление картинок, которые не были сохранены, но были подгружены в запись. так же надо сделаьт
 * удаление картинок если из записи они были удалены.
 */
class DataController extends Controller {

	public $layout = '//layouts/admin';
	public $debug = false;
	public $model_name = 'Accessory';
	private $img_folder = '/images/upload/accessory/';

	public function actionList () {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				/**
				 * @var $model Accessory
				 */
				$model = new $this->model_name();
				if ($action=='get') {
					$this->returnOk(
						 array_merge(
							 array ($model->attributeLabels()),
							 $model->getList(Yii::app()->request->getParam('id', 0))
						 )
					);
				}
			} catch(Exception $e) {
				$this->returnError($e->getMessage());
			}
		}
	}

	public function actionEdit ($id) {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$data   = $model->getFields($id);
					//echo "<pre>";print_r($data);echo "</pre>";die();
					$result = array ();
					$tables = array ();
					$fields = array ();
					foreach($data as $item) {
						$tables[$item['param_table']]                          = $item['param_table'];
						$fields[$item['param_table'].'.'.$item['param_field']] = $item['param_table'].'.'.$item['param_field'];
						$result[$item['tab_id']]['tab_name']                   = $item['tab_name'];
						$result[$item['tab_id']]['params'][]                   = array (
							'name'       => $item['field_name'],
							'field'      => $item['param_field'],
							'field_type' => $item['field_type'],
							'field_hint' => $item['field_description'],
							'exp' => $item['exp']
						);
					}
					$data = $model->getData($id, array_keys($tables), array_keys($fields));
					foreach($result as $key1 => $tab) {
						foreach($tab['params'] as $key2 => $param) {
							$result[$key1]['params'][$key2]['value'] = $data[$param['field']];
						}
					}
					$this->returnOk($result);
				}
				if ($action=='save') {
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$data   = Yii::app()->request->getParam('data');
					$data   = json_decode($data, true);
					$fields = $model->getFields($data['id']);
					$result = array ();
					foreach($fields as $item) {
						if(!empty($item['exp'])){
							if(!preg_match("/$item[exp]/",$data[$item['param_field']])){
								throw new Exception("Параметр '$item[field_name]' задан некорректно. ".$item['exp_description']);
							}
						}
						$result[$item['param_table']][$item['param_field']] = $data[$item['param_field']];
					}
					$model->updateDate($result);
					$this->returnOk(array(array("message"=>'Данные успешно обновлены.')));
				}
			} catch(Exception $e) {
				$this->returnError($e->getMessage());
			}
		}
	}

	public function actionDetail ($id) {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$data = $model->getDetail($id);
					$fields   = $model->getFields($id);
					$result = array();
					foreach($fields as $item) {
						$result[] = array(
							'title'=>$item['field_name'],
							'value'=>$data[$item['param_field']]
						);
					}
					$this->returnOk(
						 $result
					);
				}
			} catch (Exception $e){
				$this->returnError($e->getMessage());
			}
		}
	}

	public function actionDelete () {
		if($this->isAjaxRequest()){
			try {
				$action = $this->getRequest();
				$id = Yii::app()->request->getParam('id');
				if($action=='delete'){
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$model->deleteModule($id);
					$this->returnOk(array(array("message"=>'Запись успешно удалена.')));
				}
			} catch (Exception $e){
				$this->returnError($e->getMessage());
			}
		}
	}
	public function actionNew () {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				if ($action=='save') {
					try {
						/**
						 * Получаем параметры, вызываем объект модели
						 */
						$data   = Yii::app()->request->getParam('data');
						$type_id   = Yii::app()->request->getParam('type_id');
						$parent_id   = Yii::app()->request->getParam('parent_id');
						$data   = json_decode($data, true);
						$model = new $this->model_name();
						/**
						 * @var $model Accessory
						 */
						/**
						 * Получаем список полей для данного типа данных.
						 * Так же получаем родительский объект, под которым будет создаваться текущий объект.
						 * Далее создаем массив вида
						 *  таблица=>
						 * 		поле=>значение
						 * 		...
						 *
						 */
						$fields = $model->getFieldsForType($type_id);
						$result = array();
						$parentElement = $model->getElement($parent_id);
						foreach($fields as $item) {
							if(!empty($item['exp'])){
								if(!preg_match("/$item[exp]/",$data[$item['param_field']])){
									throw new Exception("Параметр '$item[field_name]' задан некорректно. ".$item['exp_description']);
								}
							}
							$result[$item['param_table']][$item['param_field']] = $data[$item['param_field']];
						}
						/**
						 * После заполнения данными массива добиваем данные дефолтовые, а именно
						 * - путь
						 * - можно ли удалить
						 * - родительский элемент
						 */
						$result[$model->generalTable]['type_id'] = $type_id;
						$result[$model->generalTable]['parent_id'] = $parent_id;
						if($parentElement['path']){
							$parentPath = explode(',',$parentElement['path']);
							array_push($parentPath,$parent_id);
							$parentPath = implode(',',$parentPath);
						} else {
							$parentPath = $parent_id;
						}
						$result[$model->generalTable]['path'] = $parentPath;
						$result[$model->generalTable]['can_delete'] = !isset($result[$model->generalTable]['can_delete']) || $result[$model->generalTable]['can_delete']===''?1:$result[$model->generalTable]['can_delete'];
						/**
						 * Сохраняем полученные данные.
						 */
						$model->setElementFull($result, true);
						$this->returnOk(array(array("message"=>'Запись успешно создана')));
					} catch(Exception $e) {
						$this->returnError($e->getMessage());
					}
				}
				if ($action=='get') {
					$id     = Yii::app()->request->getParam('type_id');
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$data   = $model->getFieldsForType($id);
					//echo "<pre>";print_r($data);echo "</pre>";die();
					$result = array ();
					$tables = array ();
					$fields = array ();
					foreach($data as $item) {
						$tables[$item['param_table']]                          = $item['param_table'];
						$fields[$item['param_table'].'.'.$item['param_field']] = $item['param_table'].'.'.$item['param_field'];
						$result[$item['tab_id']]['tab_name']                   = $item['tab_name'];
						$result[$item['tab_id']]['params'][]                   = array (
							'name'       => $item['field_name'],
							'field'      => $item['param_field'],
							'field_type' => $item['field_type'],
							'field_hint' => $item['field_description'],
						);
					}
					$this->returnOk($result);
				}
			} catch (Exception $e){
				$this->returnError($e->getMessage());
			}
		}
	}

	protected function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}

	public function actionHierarchy () {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$id     = Yii::app()->request->getParam('id');
					$this->returnOk($model->getHierarchy($id));
				}
			} catch(Exception $e) {
				$this->returnError($e->getMessage());
			}
		}
	}

	/**
	 * @param string $param
	 * @return mixed
	 */
	private function getRequest ($param = 'action') {
		$action = Yii::app()->request->getParam($param);
		return $action;
	}

	public function actionBreadcrumbs () {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				$id     = Yii::app()->request->getParam('id');
				if ($action=='get') {
					$model = new $this->model_name();
					/**
					 * @var $model Accessory
					 */
					$result = $model->getBreadcrumbs($id);
					$result = array_merge(
						array (
							  array (
								  'id'   => '',
								  'name' => 'Аксессуары'
							  )
						),
						$result
					);
					$this->returnOk($result);
				}
			} catch(Exception $e) {
				$this->returnError($e->getMessage());
			}
		}
	}

	private function returnError ($data) {
		header("HTTP/1.0 500 Internal Server Error");
		$this->returnMessage($data);
	}

	private function returnMessage ($data) {
		echo $data;
	}

	private function returnOk ($data) {
		echo json_encode($data);
	}

	public function actionUpload(){
		if ($this->isAjaxRequest()) {
			$result = array();
			try {
				if(empty($_FILES)){
					throw new Exception('Не удалось получить изображение.');
				}
				foreach($_FILES as $key=>$img) {
					$ext = pathinfo($img['name']);
					$str = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$this->img_folder;
					$path = $str.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'original'.DIRECTORY_SEPARATOR;
					$this->checkFolder($path);
					$filename = time().'('.$ext['filename'].').'.$ext['extension'];
					$result  = array(
						'ok'=>1,
						'param'=>$key,
						'message'=>$filename
					);
					$destination = $path.$filename.'.tmp';
					if(!move_uploaded_file($img['tmp_name'], $destination)){
						throw new Exception('Не удалось загрузить файл.');
					}
					$this->resizeImage($destination, $str, $filename);
				}
			} catch(Exception $e) {
				$result['ok']  = 0;
				$result['message'] = $e->getMessage();
			}
			$this->returnOk($result);
		}
	}

	/**
	 * @param $path
	 * @throws Exception
	 */
	private function checkFolder ($path) {
		if (!file_exists($path)) {
			mkdir($path,0777,true);

		}
		if (!file_exists($path)) {
			throw new Exception('Не удалось создать папку.');
		}
	}

	/**
	 * @param $destination
	 * @param $str
	 * @param $filename
	 */
	private function resizeImage ($destination, $str, $filename) {
		$f        = $destination;
		$src      = imagecreatefromjpeg($f);
		$w_src    = imagesx($src);
		$h_src    = imagesy($src);
		$h        = 128; // пропорциональная шириной 128
		$ratio    = $h_src/$h;
		$w_dest   = round($w_src/$ratio);
		$h_dest   = round($h_src/$ratio);
		$dest     = imagecreatetruecolor($w_dest, $h_dest);
		$str1 = $str.DIRECTORY_SEPARATOR.'tmp';
		$this->checkFolder($str1);
		$img_mini = $str1.DIRECTORY_SEPARATOR.$filename;
		imagecopyresized($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
		imageJpeg($dest, $img_mini);
	}
}