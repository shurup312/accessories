<?php

/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль создания модулей
 * @subpackage Контроллер отдачи дизайнов для конкретных страниц.
 * @version    Version 0.11
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
		if (!RequestUtil::getInstance()->isAjaxRequest()) {
			return false;
		}
		$this->renderPartial('list');
	}

	/**
	 * Отдает дизайн для страницы создания новой записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionNew () {
		if (!RequestUtil::getInstance()->isAjaxRequest()) {
			return false;
		}
		$this->renderPartial('new');
	}

	/**
	 * Отдает дизайн для страницы деталей записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionDetail () {
		if (!RequestUtil::getInstance()->isAjaxRequest()) {
			return false;
		}
		$this->renderPartial('detail');
	}

	/**
	 * Отдает дизайн для страницы редактирования записи
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionEdit () {
		if (!RequestUtil::getInstance()->isAjaxRequest()) {
			return false;
		}
		$this->renderPartial('edit');
	}

	/**
	 * Отдает дизайн для страницы редактирования записи
	 *
	 * @access public
	 * @since  0.11
	 * @todo Вынести в отдельный класс
	 */
	public function rightsError () {
		if (!RequestUtil::getInstance()->isAjaxRequest()) {
			return false;
		}
		$this->renderPartial('error');
	}
}