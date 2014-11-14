<?php
class IndexController extends Controller 
{
	public $layout = 'column';
	/**
	 * 商品
	 */
	private $goodM;
	/**
	 * 初始化函数
	 */
	public function init()
	{
		parent::init();
		$this->goodM = new WowGood();
	}
	/**
	 * @return array action filters
	 */
    public function filters()
	{
		return array(
			array ( 'COutputCache + index,find',
					'duration' => 20,// cache 20s
					'varyByParam' => array('itemId'),
			),
			array ( 'COutputCache + detail',
					'duration' => 60,// cache 1m
			)
			
		);
	}
	
	/****************** 购买相关 start */
	/**
	 * 首页 常用商品偏好
	 *
	 */
	public function actionIndex()
	{
		// 1 参数验证
		$itemId = intval( $this->get('itemId') );
		if( !$itemId  ){
			$itemId = 4306;
		}
		
		// 2 查询数据
		$data = $this->goodM -> searchById( $itemId );
		
		// 3 模板输出
		$this->render('index', array(
			'total' 	=> $data['total'],	   // 总数
			'data'		=> $data['data'],	   // 纪录
			'xsToken'	=> $data['xsToken'],   // xsToken
			
			'itemId'	=> $itemId,
		));
	}
	/**
	 * 商品查询
	 *
	 */
	public function actionSearch()
	{
		// 1 查询条件设置默认值
		$where = $this->get('where');
		if( !valid_array($where)){
			$where = array(
				'type1' => 5,
				'type2' => 94,
			);
		}
		
		// 2 查询数据
		$name = $where['name'];
		$filterId = $where['type2'] ? ($where['type1'].','.$where['type2']) : $where['type1'];
		$data = $this->goodM -> search( $filterId, $name);

		// 3 模板输出
		$this->render('search', array(
			'total' 	=> $data['total'],	   // 总数
			'data'		=> $data['data'],	   // 纪录
			'xsToken'	=> $data['xsToken'],   // xsToken
			'types1'	=> Yii::app()->params['wow_types1'],
			'types2'	=> Yii::app()->params['wow_types2'],
			'where'	    => $where,
		));
	}
	/**
	 * 商品查询
	 *
	 */
	public function actionFind()
	{
		// 1 参数验证
		$itemId = intval( $this->get('itemId') );
		if( !$itemId  ){
			echo '';exit;
		}
		
		// 2 查询数据
		$data = $this->goodM -> searchById( $itemId );
		
		if(!valid_array($data)){
			echo '';exit;
		}
		
		//$minStr = $data[0]['group'];
		
		// 3 模板输出
		$this->layout = false; 
		$this->render('find', array(
			'total' 	=> $data['total'],	   // 总数
			'data'		=> $data['data'],	   // 纪录
			'xsToken'	=> $data['xsToken'],   // xsToken
			
			'itemId'	=> $itemId,
		));
	}
	

	/**
	 * 购买操作
	 */
	 public function actionBuy(){
	 	$auc  	= $this->get('auc');
	 	$money	= $this->get('money');
		$xsToken= $this->get('xsToken');
		$data = $this->goodM -> buyGood($auc,$money,$xsToken);
		if( $data ){
			$this->jsonOut(true,'成功');
		}else{
			$this->jsonOut(false,'数据不能为空');
		}
	 }
	/****************** 购买相关 end */
	
	
	/****************** 出售相关 start */
	/**
	 * 出售列表
	 *
	 */
	public function actionMyGood()
	{
		// 获取拍卖行数据
		$data = $this->goodM -> myGood();

		// 模板输出
		$this->render('mygood', array(
			'data'		=> $data,
		));
		
	}

	/**
	 * 出售操作
	 */
	 public function actionCreateAuction(){
	 	// 1 参数获取
	 	$itemId 	= intval( $this->post('itemId') );
	 	$duration 	= intval( $this->post('duration') );

	 	$quantity 	= intval( $this->post('quantity') );
		$stacks 	= intval( $this->post('stacks') );
		
	 	$bid 		= intval( $this->post('bid') );
	 	$buyout 	= intval( $this->post('buyout') );
		
	 	$type 		= $this->post('type');
	 	$sourceType = intval( $this->post('sourceType') );

		// 2 参数验证
		if(  $itemId <= 0 ){
			$this->jsonOut(false,'必须选择一个商品');
		}
		if( !is_numeric($duration) ){
			$this->jsonOut(false,'必须指定持续时间');
		}
		if(  $quantity <= 0 ){
			$this->jsonOut(false,'必须指定每组数量');
		}
		if(  $stacks <= 0 ){
			// 其实目前这里永远为1
			$this->jsonOut(false,'必须指定组数');
		}

		if( !$bid ){
			// 其实目前这里还没有竞拍价的设置
			$bid = $buyout;
		}
		if( $bid <= 0 ){
			$this->jsonOut(false,'必须指定竞拍价');
		}

		if( $buyout <= 0 ){
			$this->jsonOut(false,'必须指定一口价');
		}
		
		if( $bid > $buyout ){
			// 其实目前这里竞拍价永远等于一口价
			$this->jsonOut(false,'竞拍价不能大于一口价');
		}
		
		if( !$type ){
			$type = 'perStack';
		}
		if( !$sourceType ){
			$sourceType = 0;
		}
		
		// 3 进行
		$data = $this->goodM -> createAuction( $itemId, $duration, $stacks, $quantity, $bid, $buyout, $type, $sourceType );
		if( $data ){
			$this->jsonOut(true,'成功');
		}else{
			$this->jsonOut(false,'数据不能为空');
		}
	 }
	
	/****************** 出售相关 end */
	
	
	/******************  拍卖相关 start */
	/**
	 * 拍卖列表
	 *
	 */
	public function actionAuction()
	{
		// 获取拍卖行数据
		$data = $this->goodM -> auction();
		
		// 模板输出
		$this->render('auction', array(
			'total' 	=> $data['total'],	   // 总数
			'data'		=> $data['data'],	   // 纪录
			'xsToken'	=> $data['xsToken'],   // xsToken
		));
		
	}
	/**
	 * 取消拍卖
	 */
	 public function actionCancel(){
	 	$auc  	= $this->get('auc');
		$xsToken= $this->get('xsToken');
		$data = $this->goodM -> cancelGood($auc,$xsToken);
		if( $data ){
			$this->jsonOut(true,'成功');
		}else{
			$this->jsonOut(false,'未能成功,刷新页面或者重新登录试试');
		}
	 }
	 
	/******************  拍卖相关 end */

	
	/******************  角色相关 start */
	/**
	 * 角色详情
	 */
	public function actionDetail(){	
		$roleDetail = $this->goodM -> roleDetail();

		$this->render('detail', array(
			'money' 	=> $roleDetail -> money,  
			'money_str' => $roleDetail -> money_str,  
			'role'		=> $roleDetail -> character,	 
		));
	}
	/******************  角色相关 end */
	
	
	/**
	 * 删除cookie 强制刷新
	 *
	 */
	public function actionRefresh()
	{
		$filename = dirname(__FILE__).'/../runtime/cookie.txt';
		unlink($filename);
		$this->chkLogin();
	}
}