<?php
/**
 * @author     Приходько Олег <shurup@e-mind.ru>
 * @package    Модуль создания модулей
 * @subpackage Модуль управления контроллерами
 * @version    Version 0.1
 */
class ModuleModule extends CWebModule {

	public function init () {
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(
			 array (
				   'module.models.*',
				   'module.components.*',
			 )
		);
	}

	/**
	 * @param CController $controller
	 * @param CAction     $action
	 * @return bool
	 */
	public function beforeControllerAction ($controller, $action) {
//		$rights = 'module.'.$controller->getId().'.'.$action->getId();
//		if(true || Rights::check($rights, $user->rights)){
//			if(RequestUtil::getInstance()->isAjaxRequest()){
//				$controller->rightsError();
//
//			} else {
//				$controller->rightsError();
//			}
//			return false;
//		}

		if (parent::beforeControllerAction($controller, $action)) {

			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}
}
