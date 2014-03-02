<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Расширения для работы с запросами
 * @subpackage Расширения для работы с запросами
 * @version    Version 0.1
 */

class RequestUtil {
	private static $instance;
	private function __construct(){}

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