<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Расширения для работы с запросами
 * @subpackage Расширения для работы с запросами
 * @version    Version 0.1
 */

class RequestUtil {

	/**
	 * @var bool $debug Указывает, все ли запросы воспринимать как ajax или нет.
	 */
	private $debug=false;
	/**
	 * @var object $instance хранит экземпляр класса, созданный через getInstance
	 */
	private static $instance;
	/**
	 * Конструктор класса, закрыт от внешного использования, так как класс реализует паттерн "Синглтон".
	 * @access private
	 * @since  0.1
	 *
	 * @return RequestUtil
	 */
	private function __construct(){}

	/**
	 * Конструктор инстанса.
	 * @access public
	 * @since  0.1
	 *
	 * @return RequestUtil
	 */
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new RequestUtil();
		}
		return self::$instance;
	}
	/**
	 * Возвращает результат проверки, является ли запрос Ajax запросом.
	 *
	 * @access public
	 * @since  0.1
	 * @return bool
	 */
	public function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}

} 