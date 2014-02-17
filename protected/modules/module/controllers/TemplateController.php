<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 18.01.14
 * Time: 15:48
 */
class TemplateController extends Controller {

	public $layout = '//layouts/admin';
	public $debug = false;

	public function actionList () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('list');
		}
	}
	public function actionNew () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('new');
		}
	}

	public function actionDetail () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('detail');
		}
	}

	public function actionEdit () {
		if ($this->isAjaxRequest()) {
			$this->renderPartial('edit');
		}
	}

	protected function isAjaxRequest () {
		return Yii::app()->request->isAjaxRequest || $this->debug;
	}
} 