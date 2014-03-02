<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль создания модулей
 * @subpackage Контроллер данных для Ajax запросов
 * @version    Version 0.11 $Id: module.dataController v 0.11 2014-03-01 12:00:00$
 */

/**
 * @todo: не работает создание записи для модуля
 */
class DataController extends Controller {

	public $layout = '//layouts/admin';
	public $debug = false;
	public $model_name = 'Module';
	private $img_folder = '/images/upload/module/';

	/**
	 * Возвращает список доступных записей в записи, ID которой передан в качестве параметра.
	 *
	 * @access public
	 * @since  0.1
	 * @throws DataException
	 */
	public function actionList () {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Получение списка записей.', true);
			try {
				$action = $this->getRequest();
				$model  = new $this->model_name();
				if ($action=='get') {
					$this->returnOk(
						 array_merge(
							 array ($model->attributeLabels()),
							 $model->getList(Yii::app()->request->getParam('id', 0))
						 )
					);
					$log->result = true;
				}
			} catch(DataException $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Возвращает данные о записи или принимает новые данные, которыми обновляет старые у записи.
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @param integer $id ID записи, данные которой надо отредактировать
	 * @throws DataException
	 */
	public function actionEdit ($id) {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Редактирование записи.', true);
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$log->appendDescription('Получение данных.');
					/**
					 * @var Module $model
					 */
					$model  = new $this->model_name();
					$data   = $model->getFields($id);
					$result = array ();
					$tables = array ();
					$fields = array ();
					foreach($data as $item) {
						$tables[$item['param_table']]                          = $item['param_table'];
						$fields[$item['param_table'].'.'.$item['param_field']] = $item['param_table'].'.'.$item['param_field'];
						$result[$item['tab_id']]['tab_name']                   = $item['tab_name'];
						$arr                                                   = array (
							'name'       => $item['field_description'],
							'field'      => $item['param_field'],
							'field_type' => $item['field_type'],
							'exp'        => $item['exp']
						);
						$method_name                                           = ucfirst($item['callback']);
						/**
						 * Проверяем, что у нас есть коллбэк на изменение поля в классе коллбэков для изменени полей и,
						 * если есть, то вызываем
						 */
						$getCallbacks = new getCallbacks();
						if (!empty($item['callback']) && !method_exists($getCallbacks, $method_name)) {
							throw new DataException('Не найдена функция-коллбэк для получения параметра "'.$item['field_description'].'" ("'.$method_name.'()").');
						}
						if (!empty($item['callback'])) {
							$arr = $getCallbacks->$method_name($arr);
						}
						$result[$item['tab_id']]['params'][] = $arr;
					}
					$data = $model->getData($id, array_keys($tables), array_keys($fields));
					foreach($result as $key1 => $tab) {
						foreach($tab['params'] as $key2 => $param) {
							$result[$key1]['params'][$key2]['value'] = $data[$param['field']];
						}
					}
					$log->result = true;
					$this->returnOk($result);
				}
				if ($action=='save') {
					$log->appendDescription('Сохранение данных.');
					$model  = new Module();
					$data   = Yii::app()->request->getParam('data');
					$data   = json_decode($data, true);
					$fields = $model->getFields($data['id']);
					$result = array ();
					foreach($fields as $item) {
						if ((bool)$data[$item['param_field']]==false && (bool)$item['available_null']==false) {
							throw new Exception("Параметр '$item[field_description]' не может быть пустым.");
						}
						if (!empty($item['exp'])) {
							if (!preg_match("/$item[exp]/", $data[$item['param_field']])) {
								throw new Exception("Параметр '$item[field_description]' задан некорректно. ".$item['exp_description']);
							}
						}
						$result[$item['param_table']][$item['param_field']] = $data[$item['param_field']];
					}
					$type          = $model->getType($data['type_id']);
					$method_name   = ucfirst($type['callback']);
					$saveCallbacks = new saveCallbacks();
					if (!empty($type['callback']) && !method_exists($saveCallbacks, $method_name)) {
						throw new Exception('Не найдена функция-коллбэк для редактирования данного объекта ("'.$method_name.'()").');
					}
					$model->updateDate($result);
					if (!empty($type['callback'])) {
						$saveCallbacks->$method_name($result);
					}
					$this->returnOk(array (array ("message" => 'Данные успешно обновлены.')));
					$log->result = true;
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Отдает детали о записи, ID которой передано в качестве параметра
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @param integer $id ID записи, детали которой надо вернуть
	 * @throws DataException
	 */
	public function actionDetail ($id) {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Получение деталей записи '.$id.'.', true);
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$module = new Module();
					$data   = $module->getDetail($id);
					$fields = $module->getFields($id);
					$result = array ();
					foreach($fields as $item) {
						$result[] = array (
							'title' => $item['field_description'],
							'value' => $data[$item['param_field']]
						);
					}
					$this->returnOk(
						 $result
					);
					$log->appendDescription('Данные успешно получены.');
					$log->result = true;
				}
			} catch(Exception $e) {
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Удаляет запись, ID которой перенадо в качестве GET параметра.
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @throws DataException
	 */
	public function actionDelete () {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Удаление записи.');
			try {
				$action = $this->getRequest();
				$id     = Yii::app()->request->getParam('id');
				$log->appendDescription('Запись с ID='.$id);
				if ($action=='delete') {
					$module = new Module();
					$module->deleteModule($id);
					$this->returnOk(array (array ("message" => 'Запись успешно удалена.')));
					$log->result = true;
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Возвращает данные о полях для формы создания новой записи с переданным в качестве GET параметра типом, или же
	 * принимает данные и создает запись.
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @throws DataException
	 */
	public function actionNew () {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Новая запись.', true);
			try {
				$action = $this->getRequest();
				if ($action=='save') {
					$log->appendDescription('Создание записи.');
					try {
						/**
						 * Получаем параметры, вызываем объект модели
						 */
						$data      = Yii::app()->request->getParam('data');
						$type_id   = Yii::app()->request->getParam('type_id');
						$parent_id = Yii::app()->request->getParam('parent_id');
						$data      = json_decode($data, true);
						$module    = new Module();
						/**
						 * Получаем список полей для данного типа данных.
						 * Так же получаем родительский объект, под которым будет создаваться текущий объект.
						 * Далее создаем массив вида
						 *  таблица=>
						 *        поле=>значение
						 *        ...
						 *
						 */
						$fields        = $module->getFieldsForType($type_id);
						$result        = array ();
						$parentElement = $module->getElement($parent_id);
						$type          = $module->getType($type_id);
						$method_name   = ucfirst($type['callback']);
						$newCallbacks  = new newCallbacks();
						if (!empty($type['callback']) && !method_exists($newCallbacks, $method_name)) {
							throw new Exception('Не найдена функция-коллбэк для создания данного объекта ("'.$method_name.'()").');
						}
						foreach($fields as $item) {
							$param = !isset($data[$item['param_field']])
								?''
								:$data[$item['param_field']];
							if (!empty($item['exp'])) {
								if (!preg_match("/$item[exp]/", $param)) {
									throw new Exception("Параметр '$item[field_description]' задан некорректно. ".$item['exp_description']);
								}
							}
							$result[$item['param_table']][$item['param_field']] = $param;
						}
						/**
						 * После заполнения данными массива добиваем данные дефолтовые, а именно
						 * - путь
						 * - можно ли удалить
						 * - родительский элемент
						 */
						$result[$module->generalTable]['type_id']   = $type_id;
						$result[$module->generalTable]['parent_id'] = $parent_id;
						if ($parentElement['path']) {
							$parentPath = explode(',', $parentElement['path']);
							array_push($parentPath, $parent_id);
							$parentPath = implode(',', $parentPath);
						} else {
							$parentPath = $parent_id;
						}
						$result[$module->generalTable]['path']       = $parentPath;
						$result[$module->generalTable]['can_delete'] = !isset($result[$module->generalTable]['can_delete']) || $result[$module->generalTable]['can_delete']===''
							?1
							:$result[$module->generalTable]['can_delete'];
						/**
						 * Сохраняем полученные данные.
						 */
						$module->setElementFull($result, true);
						if (!empty($type['callback'])) {
							$this->$newCallbacks($result);
						}
						$this->returnOk(array (array ("message" => 'Запись успешно создана')));
						$log->appendDescription('Запись успешно создана.');
						$log->result = true;
					} catch(Exception $e) {
						$log->appendDescription($e->getMessage());
						$this->returnError($e->getMessage());
					}
				}
				if ($action=='get') {
					$id = Yii::app()->request->getParam('type_id');
					$log->appendDescription('Получение полей для построения формы создания новой записи.');
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
					$log->appendDescription('Данные успешно отправлены.');
					$log->result = true;
					$this->returnOk($result);
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Возвращает результат проверки, является ли запрос Ajax запросом.
	 *
	 * @access protected
	 * @since  0.1
	 * @return bool
	 */
	protected function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}

	/**
	 * Возвращает данные о полях для формы создания новой записи с переданным в качестве GET параметра типом, или же
	 * принимает данные и создает запись.
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @throws DataException
	 */
	public function actionHierarchy () {
		/**
		 * Запуск логгирования
		 */
		$log = new dataLog('Получение иерархии, какой объект в каком может создаваться.', true);
		if ($this->isAjaxRequest()) {
			try {
				$action = $this->getRequest();
				if ($action=='get') {
					$module = new Module();
					$id     = Yii::app()->request->getParam('id');
					$this->returnOk($module->getHierarchy($id));
					$log->appendDescription('Данные успешно получены.');
					$log->result = true;
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
		}
		$log->stop();
		new observableLog(true, $log);
	}

	/**
	 * Возвращает значение GET параметра с заданным именем или false, если такой параметр не найден.
	 *
	 * @access private
	 * @since  0.1
	 *
	 * @throws DataException
	 * @param string $param Название GET/POST параметра, значение которого надо вернуть.
	 * @return mixed
	 */
	private function getRequest ($param = 'action') {
		$action = Yii::app()->request->getParam($param);
		return $action;
	}

	/**
	 * Возвращает хлебные крошки для указанной записи.
	 *
	 * @access public
	 * @since  0.1
	 *
	 * @throws DataException
	 */
	public function actionBreadcrumbs () {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Получение хлебных крошек.', true);
			try {
				$action = $this->getRequest();
				$id     = Yii::app()->request->getParam('id');
				$log->appendDescription("Запись $id.");
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
					$log->appendDescription('Данные успешно получены.');
					$log->result = true;
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$this->returnError($e->getMessage());
			}
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Выводит строку, переданную в качестве параметра, указав при этом 500-ый заголовок.
	 *
	 * @access   private
	 * @since    0.1
	 *
	 * @param  string $data Строка для вывода
	 */
	private function returnError ($data) {
		header("HTTP/1.0 500 Internal Server Error");
		$this->returnMessage($data);
	}

	/**
	 * Выводит строку, переданную в качестве параметра.
	 *
	 * @access   private
	 * @since    0.1
	 *
	 * @param  string $data Строка для вывода
	 */
	private function returnMessage ($data) {
		echo $data;
	}

	/**
	 * Возвращает JSON строку переданного параметра.
	 *
	 * @access   private
	 * @since    0.1
	 *
	 * @param  string $data Строка для конвертации в JSON
	 */
	private function returnOk ($data) {
		echo json_encode($data);
	}

	/**
	 * Метод, в которой приходят данные о загружаемом изображении, возваращает данные об удачном выполнении загрузки или
	 * сообщение ошибки.
	 *
	 * @access   private
	 * @since    0.1
	 *
	 * @throws DataException
	 *
	 */
	public function actionUpload () {
		if ($this->isAjaxRequest()) {
			/**
			 * Запуск логгирования
			 */
			$log = new dataLog('Загрузка изображения.', true);
			$result      = array ();
			try {
				if (empty($_FILES)) {
					throw new Exception('Не удалось получить изображение.');
				}
				foreach($_FILES as $key => $img) {
					$ext  = pathinfo($img['name']);
					$str  = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$this->img_folder;
					$path = $str.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR.'original'.DIRECTORY_SEPARATOR;
					$log->appendDescription('Проверяем папку, в которой надо будет хранить изображение.');
					$this->checkFolder($path);
					$log->appendDescription('Папка в порядке.');
					$filename = time().'('.$ext['filename'].').'.$ext['extension'];
					$result   = array (
						'ok'      => 1,
						'param'   => $key,
						'message' => $filename
					);
					$source   = $path.$filename.'.tmp';
					$log->appendDescription('Загружаем изображение в папку.');
					if (!move_uploaded_file($img['tmp_name'], $source)) {
						throw new Exception('Не удалось загрузить файл.');
					}
					$log->appendDescription('Все успешно загрузилось.');
					$destination_temp = $str.DIRECTORY_SEPARATOR.'tmp';
					$log->appendDescription('Проверяем папку для создания превьюшек.');
					$this->checkFolder($destination_temp);
					$log->appendDescription('Папка в порядке, создаем превьюшку.');
					$this->resizeImage($source, $destination_temp, $filename);
					$log->appendDescription('Успешно создалось.');
					$log->result = true;
				}
			} catch(Exception $e) {
				$log->appendDescription($e->getMessage());
				$result['ok']      = 0;
				$result['message'] = $e->getMessage();
			}
			$this->returnOk($result);
			$log->stop();
			new observableLog(true, $log);
		}
	}

	/**
	 * Создает папку с указанным адресом. Папка создается рекурсивно, права проставляются как 0777
	 *
	 * @access   private
	 * @since    0.1
	 * @param $path
	 *
	 * @throws DataException
	 */
	private function checkFolder ($path) {
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		if (!file_exists($path)) {
			throw new DataException('Не удалось создать папку.');
		}
	}

	/**
	 * Делает изобращение размером $height и шириной, высчитанной пропорционально и сохраняет файл в папку $desctination
	 * с именем $filename
	 *
	 * @access   private
	 * @since    0.1
	 *
	 * @param string $source
	 * @param string $destination
	 * @param string $filename
	 * @param int    $height
	 */
	private function resizeImage ($source, $destination, $filename, $height = 128) {
		$f        = $source;
		$src      = imagecreatefromjpeg($f);
		$w_src    = imagesx($src);
		$h_src    = imagesy($src);
		$ratio    = $h_src/$height;
		$w_dest   = round($w_src/$ratio);
		$h_dest   = round($h_src/$ratio);
		$dest     = imagecreatetruecolor($w_dest, $h_dest);
		$img_mini = $destination.DIRECTORY_SEPARATOR.$filename;
		imagecopyresized($dest, $src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
		imageJpeg($dest, $img_mini);
	}
}

/**
 * Class getCallbacks
 *
 * Класс, который содержит методы-коллбэки, вызываемые при запросе полей записей.
 */
class getCallbacks {

	/**
	 * Коллбэк вызываемый при отдаче по Ajax информации о поле visible типа "параметр"
	 *
	 * @param $arr
	 * @return mixed
	 */
	public function SetVisibleOptions ($arr) {
		$arr['options'] = array (
			'0' => 'Нигде',
			'1' => 'Cоздание',
			'2' => 'Редактирование',
			'3' => 'Редактирование и создание',
			'4' => 'Групповое редактирование',
			'5' => 'Создание и групповое редактирование',
			'6' => 'Редактирование как простое так и групповое',
			'7' => 'Создание, редактирование и групповое переименование'
		);
		return $arr;
	}
}

/**
 * Class saveCallbacks
 *
 * Класс, который содержит методы-коллбэки, вызываемые при сохранении записи.
 */
class saveCallbacks {

}

/**
 * Class newCallbacks
 *
 * Класс, который содержит методы-коллбэки, вызываемые при создании записи.
 */
class newCallbacks {

}

/**
 * Class DataException
 *
 * Субкласс от суперкласса исключений, для исключений внутри текущего контроллера.
 */
class DataException extends Exception {

}

/**
 * Class dataLog
 *
 * Класс, который содержит все данные лога.
 */
class dataLog {

	/**
	 * @var float Время выполнения скрипта
	 */
	public $time = 0;
	/**
	 * @var string Массив сообщений лога
	 */
	public $description = '';
	/**
	 * @var bool Удачно ли выполнился скрипт, который логгируется
	 */
	public $result;
	/**
	 * @var float Внутренняя переменная, хранит данные о времени с начала логгирования и до его кончания.
	 */
	private $timeperiod = 0;

	/**
	 * Конструктор класса
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param bool $description Описание лога
	 * @param bool $start Булево значение, показывает, надо ли стартовать таймер, который считает время логгирования.
	 * @param bool $result Результат выполнения логгируемого кода, true - если все удачно, или false, если все неудачно.
	 */
	public function dataLog ($description = false, $start = false, $result = false) {
		if($description){
			$this->setDescription($description);
		}
		if($start){
			$this->start();
		}
		$this->result = $result;
	}

	/**
	 * Задает текст лога.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param string $description
	 */
	public function setDescription ($description) {
		$this->description = $description;
	}

	/**
	 * Стартурет таймер логгирования.
	 *
	 * @access   public
	 * @since    0.1
	 */
	public function start () {
		$this->time       = 0;
		$this->timeperiod = microtime(true);
	}

	/**
	 * Останавливает таймер логгирвания, данные о времени логгирования помещает в переменную класса $time.
	 *
	 * @access   public
	 * @since    0.1
	 */
	public function stop () {
		$this->time       = microtime(true) - $this->timeperiod;
		$this->timeperiod = 0;
	}

	/**
	 * Добавляет в логу еще описание.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param $message
	 */
	public function appendDescription ($message) {
		$this->description .= " ".$message;
	}
}

/**
 * Class observableLog
 *
 * Класс-субъект, получает данные о новом логе и рассылает всем обсерверам.
 */
class observableLog {

	/**
	 * @var array Массив всех подписанных на логи обсерверов.
	 */
	private $observers = array ();
	/**
	 * @var dataLog ОБъект лога
	 */
	private $log;
	/**
	 * @var string Имя класса дефолтового логгера
	 */
	private $defaultLogger = 'TextLogger';

	/**
	 * Конструктор класса.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param bool $createLogger Если задано true, то добавляет объект дефолтового логгера в список обсерверов.
	 * @param mixed $log Принимает в качестве параметра объект типа dataLog, если объект задан, то задает текущим логом.
	 */
	public function observableLog ($createLogger=false, $log=false){
		if($createLogger){
			$logger = new $this->defaultLogger();
			$this->addLogger($logger);
		}
		if($log && ($log instanceof dataLog)){
			$this->setLog($log);
		}
	}

	/**
	 * Добавляет новый логгер в список обсерверов
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param Logger $object Объект логгера, который надо добавить в список обсерверов
	 */
	public function addLogger (Logger $object) {
		$this->observers[] = $object;
	}

	/**
	 * Оповещение всех обсерверов о новом логе.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param dataLog $log
	 */
	private function notifyLogger (dataLog $log) {
		foreach($this->observers as $observer) {
			/**
			 * @var Logger $observer
			 */
			$observer->logged($log);
		}
	}

	/**
	 * Pадание нового лога.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param dataLog $log Объект лога.
	 */
	public function setLog (dataLog $log) {
		$this->log = $log;
		$this->notifyLogger($this->log);
	}

	/**
	 * Получение последнего лога.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @return mixed
	 */
	public function getLog () {
		return $this->log;
	}
}

/**
 * Interface Logger
 *
 * Интерфейс всех логогеров.
 */
interface Logger {

	/**
	 * Метод, который реализует действия, которые логгер должен сделать с объектом лога.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param dataLog $log
	 * @return mixed
	 */
	public function logged (dataLog $log);
}

/**
 * Class TextLogger
 *
 * Логгер, который пишет логи в файл.
 */
class TextLogger implements Logger {

	/**
	 * Метод, который получает лог от класса observableLog и записывает его в файл.
	 *
	 * @access   public
	 * @since    0.1
	 *
	 * @param dataLog $log
	 * @return mixed|void
	 */

	public function logged (dataLog $log) {
		$log  = "Время выполнения: ".date(
				'd.m.y H:i:s'
			)."\r\n"."Действие: ".$log->description."\r\n"."Время выполнения: ".$log->time."\r\n"."Результат выполнения: ".($log->result
				?'true'
				:'false')."\r\n\r\n";
		$link = fopen(
			$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'logged.txt',
			'a+'
		);
		fwrite($link, $log);
		fclose($link);
	}
}