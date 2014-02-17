<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 18.01.14
 * Time: 15:50
 */

/**
 * TODO: не работает создаение записи для модуля
 */
class DataController extends Controller {

	public $layout = '//layouts/admin';
	public $debug = false;

	public function actionList () {
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				$module = new Module();
				if ($action=='get') {
					$this->returnOk(
						 array_merge(
							 array ($module->attributeLabels()),
							 $module->getList(Yii::app()->request->getParam('id', 0))
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
					$module = new Module();
					$data   = $module->getFields($id);
					//echo "<pre>";print_r($data);echo "</pre>";die();
					$result = array ();
					$tables = array ();
					$fields = array ();
					foreach($data as $item) {
						$tables[$item['param_table']]                          = $item['param_table'];
						$fields[$item['param_table'].'.'.$item['param_field']] = $item['param_table'].'.'.$item['param_field'];
						$result[$item['tab_id']]['tab_name']                   = $item['tab_name'];
						$result[$item['tab_id']]['params'][]                   = array (
							'name'       => $item['field_description'],
							'field'      => $item['param_field'],
							'field_type' => $item['field_type'],
							'exp' => $item['exp']
						);
					}
					$data = $module->getData($id, array_keys($tables), array_keys($fields));
					foreach($result as $key1 => $tab) {
						foreach($tab['params'] as $key2 => $param) {
							$result[$key1]['params'][$key2]['value'] = $data[$param['field']];
						}
					}
					$this->returnOk($result);
				}
				if ($action=='save') {
					$module = new Module();
					$data   = Yii::app()->request->getParam('data');
					$data   = json_decode($data, true);
					$fields = $module->getFields($data['id']);
					$result = array ();
					foreach($fields as $item) {
						if(!empty($item['exp'])){
							if(!preg_match("/$item[exp]/",$data[$item['param_field']])){
								throw new Exception("Параметр '$item[field_description]' задан некорректно. ".$item['exp_description']);
							}
						}
						$result[$item['param_table']][$item['param_field']] = $data[$item['param_field']];
					}
					$module->updateDate($result);
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
					$module = new Module();
					$data = $module->getDetail($id);
					$fields   = $module->getFields($id);
					$result = array();
					foreach($fields as $item) {
						$result[] = array(
							'title'=>$item['field_description'],
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
					$module = new Module();
					$module->deleteModule($id);
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
						$module = new Module();
						/**
						 * Получаем список полей для данного типа данных.
						 * Так же получаем родительский объект, под которым будет создаваться текущий объект.
						 * Далее создаем массив вида
						 *  таблица=>
						 * 		поле=>значение
						 * 		...
						 *
						 */
						$fields = $module->getFieldsForType($type_id);
						$result = array();
						$parentElement = $module->getElement($parent_id);
						foreach($fields as $item) {
							if(!empty($item['exp'])){
								if(!preg_match("/$item[exp]/",$data[$item['param_field']])){
									throw new Exception("Параметр '$item[field_description]' задан некорректно. ".$item['exp_description']);
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
						$result[$module->generalTable]['type_id'] = $type_id;
						$result[$module->generalTable]['parent_id'] = $parent_id;
						if($parentElement['path']){
							$parentPath = explode(',',$parentElement['path']);
							array_push($parentPath,$parent_id);
							$parentPath = implode(',',$parentPath);
						} else {
							$parentPath = $parent_id;
						}
						$result[$module->generalTable]['path'] = $parentPath;
						$result[$module->generalTable]['can_delete'] = !isset($result[$module->generalTable]['can_delete']) || $result[$module->generalTable]['can_delete']===''?1:$result[$module->generalTable]['can_delete'];
						/**
						 * Сохраняем полученные данные.
						 */
						$module->setElementFull($result, true);
						$this->returnOk(array(array("message"=>'Запись успешно создана')));
					} catch(Exception $e) {
						$this->returnError($e->getMessage());
					}
				}
				if ($action=='get') {
					$id     = Yii::app()->request->getParam('type_id');
					$module = new Module();
					$data   = $module->getFieldsForType($id);
					//echo "<pre>";print_r($data);echo "</pre>";die();
					$result = array ();
					$tables = array ();
					$fields = array ();
					foreach($data as $item) {
						$tables[$item['param_table']]                          = $item['param_table'];
						$fields[$item['param_table'].'.'.$item['param_field']] = $item['param_table'].'.'.$item['param_field'];
						$result[$item['tab_id']]['tab_name']                   = $item['tab_name'];
						$result[$item['tab_id']]['params'][]                   = array (
							'name'       => $item['field_description'],
							'field'      => $item['param_field'],
							'field_type' => $item['field_type'],
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
					$module = new Module();
					$id     = Yii::app()->request->getParam('id');
					$this->returnOk($module->getHierarchy($id));
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
					$module = new Module();
					$result = $module->getBreadcrumbs($id);
					$result = array_merge(
						array (
							  array (
								  'id'   => '',
								  'name' => 'Корень'
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

	public function actionEve () {
		$key       = '2981663';
		$str       = 'DQMRW8Mz15cdc68npw1aWVlNpST1tzlKahpKGxbihfn6X2txgf9y9wFwYlZdYKQj';
		$url       = "https://api.eveonline.com/account/characters.xml.aspx?keyID=$key&vCode=$str";
		$c         = file_get_contents($url);
		$xml       = simplexml_load_string($c);
		$character = "https://api.eveonline.com/char/CharacterSheet.xml.aspx?keyID=$key&vCode=$str&characterID=".$xml->result->rowset->row['characterID'];
		$c         = file_get_contents($character);
		$xml2      = simplexml_load_string($c);
		$trade     = "https://api.eveonline.com/char/MarketOrders.xml.aspx?keyID=$key&vCode=$str&characterID=".$xml->result->rowset->row['characterID'];
		$c         = file_get_contents($trade);
		$xml3      = simplexml_load_string($c);
		echo "<pre>";
		print_r($xml3);
		echo "</pre>";
		die();
		die();
		die();
	}
}