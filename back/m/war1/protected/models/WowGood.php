<?php
/**
 * 这个是表 "{{booking}}" 的模型类
 *
 */
class WowGood
{
	/**
	 * html 解析类
	 */
	private $ct;
	/**
	 * cookie 文件，用于登录验证
	 */
	private $cookieFile;
	
	/**
	 * 初始化
	 */
	public function __construct(){
		$this->ct = new Collect();
		$this->cookieFile = Yii::app()->basePath . '/runtime/cookie.txt';
	}
	
	/**
	 * 登录
	 * get
	 * https://www.battlenet.com.cn/login/zh/
	 */
	public function login(){
		// 1 获取csrftoken
		$url = 'https://www.battlenet.com.cn/login/zh/';
		$config = Yii::app()->params['wow_login'];
		$data = $this->getContent( $config, $url);
		if( $data['welcome'] ){
			return array('status'=>true,'data'=>'登陆成功');
		}elseif( !$data['csrftoken'] ){
			return array('status'=>false,'data'=>'无法获取令牌token,可能换规则了');
		}
		
		// 2 post数据
		$post = array(
			'accountName' => 'qxlijin@163.com',
			'csrftoken'	=> $data['csrftoken'],
			'password'	=> 'ljwj6225@wow',
			'persistLogin' =>'on'
		);
		$data = $this->getContent( $config, $url, $post);
		
		// 3 分析失败结果
		if( !valid_array($data) ){
			return array('status'=>false,'data'=>'登陆不上,用户名或者密码错误');
		}
		
		// 4 登陆
		if( $data['welcome'] ){
			return array('status'=>true,'data'=>'重新登陆成功');
		}else{
			return array('status'=>false,'data'=>'登陆不了，获取数据失败，可能换规则了');
		}
	}

	// 2 进入拍卖行
	public function inPamai(){
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/';
		$data = $this->curl($url);
		echo $data;exit;
	}
	
	/******************  购买相关 start */
	/**
	 * 查询数据
	 * @var str $itemId 商品id号
	 * @var str $sort : bid：竞标价格 unitBid：每件物品出价 buyout：一口价 unitBuyout：每件物品一口价
	 */
	public function searchById( $itemId, $sort = 'unitBuyout' ){
		// 1 查询条件
		$itemId = intval($itemId);
		if( !$itemId ){
			return null;
		}
		$data = array(
			'itemId'	=> $itemId,
			'start'		=> 0,
			'end'		=> 40,
			'sort'		=> $sort,
		);
		
		// 2 返回
		return $this->searchGood( $data );
	}
	/**
	 * 查询数据
	 * @var str $filterId 商品类型形如 5,94
	 * @var str $name 商品名
	 * @var str $sort : bid：竞标价格, unitBid：每件物品出价, buyout：一口价, unitBuyout：每件物品一口价
	 */
	public function search($filterId, $name, $sort = 'unitBuyout' ){
		// 1 查询条件
		$data = array(
			'n'			=> $name,		// 形如 灵纹布
			'filterId'	=> $filterId,	// 形如 5,94
			'minLvl'	=> -1,
			'maxLvl'	=> -1,
			'qual'		=> 1,
			'start'		=> 0,
			'end'		=> 40,
			'sort'		=> $sort,
			'reverse'	=> 'false'
		);
		
		// 2 返回
		return $this->searchGood( $data );
	}
	/**
	 * 查询商品
	 * 
	 * get
	 * https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/browse?
	 * 查询参数: 见 search, searchById 
	 * 
	 * @var array $data
	 * @return array [total, xsToken, data]
	 */
	private function searchGood( $data ){
		// 1 查询
		$queryStr = http_build_query($data);
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/browse?' . $queryStr;
		$config = Yii::app()->params['wow_list'];
		$data = $this->getContent( $config, $url);
		//print_test( $data );
		
		// 2 验证
		$valid = valid_array($data) && $data['total'] && $data['total'] > 0;
		if( !$valid ){
			return null;
		}
		$xsToken = $data['xsToken'];
		if( !$xsToken ){
			return null;
		}
		
		// 3 数据纪录匹配
		$rows = explode('</tr>', $data['table']);
		if( valid_array($rows) ){
			unset($rows[count($rows)-1]);
			unset($rows[0]);
		}
		
		// 4 解析详情
		$config = Yii::app()->params['wow_item'];
		$ct = $this->ct;
		$ct -> setConfig( $config );

		$newRows = array();
		foreach($rows as $row){
			$ct -> setHtml($row);
			$d = $ct -> run();
			$newRows[] = $d;
		}
		
		// 5 转换数据
		$newData = $this -> transFormat($newRows);
		//usort ($newData, array($this,'cmpPrice'));

		$data['data'] = $newData;
		return $data;
	}
	/**
	 * 购买操作
		post
		https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/bid
		auc	1736546404
		money	13182
		xtoken	dd218890-40af-4803-b015-4becf8aa9f87
	 * 
	 * @var str $auc 相当于id
	 * @var str $money 金额
	 * @var str $xtoken xss防范的令牌
	 */
	public function buyGood($auc, $money, $xtoken){
		// 验证是否为空
		if( !$auc || !$money || !$xtoken){
			return false;
		}
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/bid';
	 	$data = array();
	 	$data['auc']   	= $auc;
	 	$data['money']	= $money;
		$data['xtoken']	= $xtoken;

		$content = $this->curl( $url, $data);
		//print_test($content);// 这个不准确, 自行查看吧
		
		return true;
	}
	/****************** 购买相关 end */


	/****************** 出售相关 start */
	/**
	 * 查看我的商品列表，用于出售
	 * get
	 * https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/create
	 * 
	 */
	public function myGood(){
		$url    = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/create';
		$config = Yii::app()->params['wow_mygood'];
		$data   = $this->getContent( $config, $url );
		if( valid_array($data) && $data['data'] ){
			$d = $data['data'];
			$d = str_replace(array(
								" id:",
								"guid:",
								"key:",
								"name:",
								"icon:",
								"quality:",
								"maxQty:",
								"q0:",
								"q1:",
								"q2:",
								"q3:",
							 ), 
							 array(
                                "'id':",
                                "'guid':",
                                "'key':",
                                "'name':",
                                "'icon':",
                                "'quality':",
                                "'maxQty':",
                                "'q0':",
                                "'q1':",
                                "'q2':",
                                "'q3':",
							 ), 
							$d );
			$d = str_replace("'", '"', $d);
			$d = str_replace("};",'}', $d);
			return json_decode($d) ;
		}else{
			return null;
		}
	}
	/**
	 * 获取安全标签
	 * 
	 * post
	 * https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/deposit
	 * 
	 * @var int $itemId id号
	 * @var int $duration  0:12小时 1:24小时 2:48小时
	 * @var int $stacks 堆叠组数
	 * @var int $quantity 堆叠数量(每组数量)
	 * 
	 */
	private function deposit( $itemId, $duration, $stacks,  $quantity, $xsToken ){
		// 1 获取ticket
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/deposit';
	 	$data = array();
	 	$data['duration'] = $duration; 
		$data['item']	  = $itemId;// id 号
		$data['quan']	  = $quantity;   // 数量
		$data['sk']		  = $xsToken;// token
		$data['stacks']   = $stacks;   // 组数
		
		$content = $this->curl( $url, $data);
		$data = json_decode($content);

		// 2 返回
		if( is_object($data) && $data->ticket){
			return $data->ticket;
		}else{
			return '';
		}
	}
	/**
	 * 创建出售操作
	 * 
	 * post
	 * https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/createAuction
	 * 
	 * @var int $itemId id号
	 * @var int $duration  0:12小时 1:24小时 2:48小时
	 * @var int $stacks 堆叠组数
	 * @var int $quantity 堆叠数量(每组数量)
	 * @var int $bid 竞拍价
	 * @var int $buyout 一口价
	 * @var int $type perStack:按组 perItem:按单位
	 * @var int $sourceType 0所有 1背包 2银行 3邮件 (默认0就好)
	 */
	public function createAuction( $itemId, $duration, $stacks, $quantity, $bid, $buyout, $type='perStack', $sourceType=0 ){
		// 1 读取cookie
		$cookie = $this->cookie();
		$xsToken= $cookie['xstoken'];
		$xtoken = $cookie['xtoken'];
		if( !$xsToken || !$xtoken ){
			return false;
		}
		//return rand(0,1);// debug
		// 2 获取标签
		$ticket = $this->deposit( $itemId, $duration, $stacks,  $quantity, $xsToken );
		
		// 3 出售提交操作
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/createAuction';
		$data=array();		
		$data['bid'] 		=  $bid;
		$data['buyout'] 	=  $buyout;
		$data['duration'] 	=  $duration;
		$data['itemId'] 	=  $itemId;
		$data['quantity'] 	=  $quantity;
		$data['sourceType'] =  $sourceType;
		$data['stacks'] 	=  $stacks;
		$data['ticket'] 	=  $ticket; 
		$data['type'] 		=  'perStack';
		$data['xtoken'] 	=  $xtoken;
		
		$content = $this->curl( $url, $data);
		
		// 4 返回
		$data = json_decode($content);
		return $data;
	}
	/****************** 出售相关 end */


	/****************** 拍卖相关 start */
	/**
	 * 我的拍卖列表
		get
		https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/auctions
	 */
	public function auction(){
		// 1 采集数据
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/auctions';
		$config = Yii::app()->params['wow_auction_list'];
		$data = $this->getContent( $config, $url);
		
		// 2 验证
		$valid = valid_array($data) && $data['total'] && $data['total'] > 0;
		if( !$valid ){
			return null;
		}
		$xsToken = $data['xsToken'];
		if( !$xsToken ){
			return null;
		}
		
		// 3 数据纪录匹配
		$rows = explode('</tr>', $data['table']);
		if( valid_array($rows) ){
			unset($rows[count($rows)-1]);
			unset($rows[0]);
			unset($rows[1]);
		}
		//print_test( $rows );

		// 4 解析详情
		$config = Yii::app()->params['wow_auction'];
		$ct = $this->ct;
		$ct -> setConfig( $config );

		$newRows = array();
		foreach($rows as $row){
			$ct -> setHtml($row);
			$d = $ct -> run();
			$nums = intval( $d['quantity'] );
			if( $nums <= 0 ){
				continue;
			}
		
			$d['m1'] = intval($d['m1']);
			$d['m2'] = intval($d['m2']);
			$d['m3'] = intval($d['m3']);
			$money = $d['m1'] * 10000 + $d['m2'] * 100 + $d['m3'];
			
			$d['money'] = $money;
			$d['per']   = ceil( $money / $nums );	  // 平均单价
			$d['group'] = ceil( $money / $nums * 20 ); // 平均组价

			$d['moneys']= $this->format_wow( $d['money'] );
			$d['pers']	= $this->format_wow( $d['per'] );
			$d['groups']= $this->format_wow( $d['group'] );

			$newRows[] = $d;
		}

		$data['data'] = $newRows;
		return $data;
	}
	/**
	 * 取消拍卖操作
	 * 
		post
		https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/cancel
		auc	1736546404
		xtoken	dd218890-40af-4803-b015-4becf8aa9f87
	 * 
	 * @var str $auc 相当于id
	 * @var str $xtoken xss防范的令牌
	 */
	public function cancelGood($auc,$xtoken){
		// 验证是否为空
		if( !$auc || !$xtoken){
			return false;
		}
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/cancel';
	 	$data = array();
	 	$data['auc']   	= $auc;
		$data['xtoken']	= $xtoken;

		$content = $this->curl( $url, $data);
		//print_test($content);// 这个不准确, 自行查看吧
		
		return true;
	}
	/******************  拍卖相关 end */


	/******************  角色相关 start */
	/**
	 * 帐号信息
	 * get
	 * https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/money
	 * 
	 */
	public function roleDetail(){
		$url = 'https://www.battlenet.com.cn/wow/zh/vault/character/auction/alliance/money';
		$content = $this->curl( $url );
		$data = json_decode($content);
		if(is_object($data) && $data->money){
			$data->money_str = $this->format_wow( $data->money );
		}

		return $data;
	}
	/******************  角色相关 end */


	/******************  通用方法 start */
	/**
	 * 转换成可读的形式
	 */
	private function transFormat($newRows){
		if( !valid_array($newRows) ){
			return null;
		}
		$data = array();
		foreach($newRows as $v){
			$nums = intval($v['quantity']);
			if( $v['options'] == ''){continue;}
			if( $nums <= 0 ){continue;}
			
			$t     = explode(',', $v['options']);
			$money = trim( $t[1] ); 				  // 买卖实价
			$per   = ceil( $money / $nums );	  // 平均单价
			$group = ceil( $money / $nums * 20 ); // 平均组价

			$v['quantity']	= $nums;
			$v['auc']	    = intval( trim( $t[0] ) );
			$v['money']	    = $money;
			$v['per']	    = $per;
			$v['group']		= $group;
			$v['moneys']	= $this->format_wow( $money );
			$v['pers']	    = $this->format_wow( $per );
			$v['groups']	= $this->format_wow( $group );
			
			$data[] = $v;
		}
		
		return $data;
	}
	/**
	 * 单价比较, 用于单价从小到大排序
	 */
	public function cmpPrice($a,$b){
		return $a['per'] < $b['per'] ? -1 : 1;
	}
	/**
	 * 数字格式化 2687366 -> 26g87.366
	 * int $v
	 */
	private function format_wow2($v) {
	  $v = intval($v);
	  $output = '';
	  foreach (array(10000 => 'g', 100 => '.', 1 => '') as $key => $value) {
	    if ($v >= $key){
	    	$output .= floor($v/$key) . $value;
	    } 
	    $v %= $key;
	  }
	  return $output;
	}
	/**
	 * 数字分组 2687366 -> [268,73,66]
	 * int $v
	 */
	private function format_wow($v) {
	  $output = array();
	  foreach (array(10000,100,1) as $value) {
	    if ($v >= $value){
	    	$output[] = floor($v/$value);
	    }else{
	    	$output[] = 0;
	    }
	    $v %= $value;
	  }
	  return $output;
	}
	/**
	 * 采集类
	 * 含cookie 用于登录验证
	 * @var str url 访问地址
	 * @var array $data post数据(若get，自行放在url中)
	 * @var int $timeout 超时秒数
	 */
	private function curl( $url, $data=array(), $timeout=10 ){
		
		return curl( $url, $data, $timeout, $this->cookieFile );
	}
	/**
	 * 获取采集的数据
	 * 
	 * @var str $url
	 * @var array $config
	 */
	private function getContent( $config, $url, $post=null ){
		
		$html = $this->curl( $url, $post, 30 );
		
		$ct = $this->ct;
		$ct -> setConfig( $config );
		$ct -> setHtml($html);
		$data = $ct -> run();
		
		return $data;
	}
	/**
	 * 获取cookie文件的值
	 */
	private function cookie(){
		// 1 静态保存
		static $cookies=null;
		if( valid_array($cookies) ){
			return $cookies;
		}
		
		// 2 返回结果
		$cf = $this->cookieFile;;
		if( !file_exists($cf)){
			return null;
		}
		
		// 3 按行分隔，再按\t分隔
		$data = explode( "\r\n",file_get_contents($cf) );
		$cookies = array();
		foreach( $data as $v ){
			$vv = explode("\t",$v);
			if($vv[5]){
				$cookies[$vv[5]] = $vv[6];
			}
		}
		return $cookies;
	}
	/******************  通用方法 end */
}
