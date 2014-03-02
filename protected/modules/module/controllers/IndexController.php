<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль создания модулей
 * @subpackage Контроллер-точка входа
 * @version    Version 0.1
 */
class IndexController extends Controller {

	/**
	 * @var string $layout Путь до дизайна
	 * @var bool $debug Путь до дизайна
	 */
	public $layout = '//layouts/admin';
	public $debug = false;

	/**
	 * Просто отдает дизайн.
	 *
	 * @access public
	 * @since  0.1
	 */
	public function actionIndex () {
		$this->render('index');
	}
}