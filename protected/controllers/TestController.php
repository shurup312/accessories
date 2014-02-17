<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 14.01.14
 * Time: 23:21
 */

class TestController extends Controller {
	public $layout = '//layouts/admin';
	public function  actionIndex(){
		$this->render('index');
	}
} 