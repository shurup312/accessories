<?php

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
		$rights = 'module.'.$controller->getId().'.'.$action->getId();

		if (parent::beforeControllerAction($controller, $action)) {

			$controller->debug = true;
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else {
			return false;
		}
	}
}
