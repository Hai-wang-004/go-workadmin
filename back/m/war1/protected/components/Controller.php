<?php
/**
 * @abstract 自定义控制器中间层，用于构造公用方法
 * @author jinli@sohu-inc.com
 *
 */
class Controller extends CController {
	public $empower;
	/**
	 * 初始化控制器默认模板
	 *
	 * @var string
	 */
	public $layout='column1';
	/**
	 * 初始化控制器栏目设置
	 *
	 * @var array
	 */
	public $menu=array();
	/**
	 * 初始化面包屑导航
	 *
	 * @var array
	 */
	public $breadcrumbs=array();
	
	/**
	 * 当前登录帐号基本信息
	 * 
	 */
	protected $user;
	
	
	/**
	 * 初始化
	 */
	public function init(){
		$this->user = Yii::app()->user->getState('user');
	}
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
	//		'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated users to access all actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * 输出json结果
	 * @author lijin
	 * @param bool $status 是否成功
	 * @param type $data 返回的数据对象
	 * @param int $code 状态码，用于特殊场合下判断
	 */
	protected function jsonOut( $status, $data=null, $code=0 ){
		//header("Content-type:text/html;charset=utf-8");
		if( !$data ){
			$data = $status ? '操作成功' : '操作失败';
		}
		$data = array(
			'status'=> $status,
			'code'  => $code,
			'data'  => $data,
		);
		echo Utility::Encode($data);
		exit;
	}
	/**
	 * get 与 post 非法输入: 空格，xss等
	 * @var $name 表单名
	 * @var $isVerify 是否验证：默认是
	 */
	protected function get( $name, $isVerify=true ){
		$name = Yii::app()->request->getParam($name);
		return $isVerify ? Utility::verifys($name) : $name;
	}
	protected function post( $name, $filter=true ){
		$name = Yii::app()->request->getPost($name);
		return $isVerify ? Utility::verifys($name) : $name;
	}
	
	/**
	 * 验证登陆, 未登陆时自动登陆
	 */
	protected function chkLogin(){
		$m = new WowGood();
		$data = $m -> login();
		if( Yii::app()->request->isAjaxRequest ){
			$this->jsonOut($data['status'],$data['data']);
		}else{
			$this->showMessage( $data['data'], $this->createUrl('/'));
		}
	}
	/**
	 * 提示信息
	 */
	protected function showMessage($msg, $url_forward = 'goback', $ms = 1250, $dialog = '', $returnjs = ''){
		$this->render('showmessage', array(
			'msg'		 => $msg,	   // 纪录
			'url_forward'=> $url_forward,
			'ms' 		 => $ms,
			'dialog' 	 => $dialog,
			'returnjs'	 => $returnjs,
		));
		exit;
	}
}
