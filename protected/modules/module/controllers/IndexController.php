<?php

class IndexController extends Controller {

	public $layout = '//layouts/admin';
	public $debug = false;

	public function actionIndex () {
		$this->render('index');
	}

	/**
	 * @return bool
	 */
	protected function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}
}