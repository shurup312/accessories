<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль, отвечающий за формирование лога.
 * @subpackage Модуль, отвечающий за формирование лога.
 * @version    Version 0.11
 */


/**
 * Class DataLog
 *
 * Класс, который содержит все данные лога.
 */
class DataLog {

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