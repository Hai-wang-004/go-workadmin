<?php
class TestController extends Controller 
{
	public $layout = 'column';
	/**
	 * 楼盘首页
	 *
	 */
	public function actionIndex()
	{
		$this->render('index');
	}
}