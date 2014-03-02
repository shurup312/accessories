<?php

/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль создания модулей
 * @subpackage Контроллер отдачи дизайнов для конкретных страниц.
 * @version    Version 0.1
 */
class TemplateController extends Controller {

	/**
	 * @var string $layout Путь до дизайна
	 * @var bool   $debug  Путь до дизайна
	 */
	public $layout = '//layouts/admin';
	public $debug = false;

	/**
	 * Отдает дизайн для страницы списка записей
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionList () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('list');
		}
	}

	/**
	 * Отдает дизайн для страницы создания новой записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionNew () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('new');
		}
	}

	/**
	 * Отдает дизайн для страницы деталей записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionDetail () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('detail');
		}
	}

	/**
	 * Отдает дизайн для страницы редактирования записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionEdit () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('edit');
		}
	}

	/**
	 * Возвращает результат проверки, является ли запрос Ajax запросом.
	 *
	 * @access public
	 * @since  0.1
	 */
	protected function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}
} 