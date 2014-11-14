<?php
/**
 * 采集精简类
 * @author lijin 2013-07-26
 */
class Collect{
	private $url; // 要采集的地址
	private $html; // 需要解析的html内容页
	private $config; // 要采集数据项配置
	public function __construct(){}
	/**
	 * 获取某链接的内容并设置到成员变量html中
	 *
	 * @param str $url url
	 * @return str
	 */
	public function setUrl( $url, $timeOut=3 ){
		if ( $url ) {
			$this->html = $this->_getRemote( $url, $timeOut );
		}else{
			$this->html = '';
		}
	}
	/**
	 * 调取远程文件并且失败时重试两次.
	 *
	 * @param str $url url
	 * @param int $timeOut 超时时间
	 * @return str 
	 */
	private function _getRemote( $url, $timeOut=3 ){
		return curl($url,null,$timeOut);
		/*$opts = array('http'=>array('method'=>"GET",'timeout'=>$timeOut));
		$context = stream_context_create( $opts );
		
		$content = '';
		for( $i=0; $i < 2; $i++ ){
			$content = @file_get_contents( $url, false, $context );
			if( $content !== false ){
				break;
			}
		}
		return $content;*/
	}
	/**
	 * 设置数据项匹配
	 */
	public function setConfig( $config ){
		$this->config = $config;
	}
	/**
	 * 直接设置html内容
	 *
	 * @param str $html
	 */
	public function setHtml($html){
		$this->html = $html;
	}
	public function getHtml(){
		return  $this->html;
	}
	/**
	 * 解析数据
	 *
	 * @param str $pkname 包名
	 */
	public function run(){
		// 1) 验证配置是否存在
		if( !is_array( $this->config ) || empty( $this->config ) ){
			return null;
		}
		
		// 2) 解析通用配置项
		$data = array();
		foreach ( $this->config as $k => $config ){
			// 1) 根据匹配规则获取需要的数据项
			$result = $this -> getItem( $this->html, $config );
			
			// 2) 有的是直接返回，有的需要合并在一起,由返回结果的status指定，以后还可以扩展其它的
			if( is_array( $result ) && isset( $result['__CTYPE__'] ) ){
				// 1. 分析出处理类型
				$ctype = $result['__CTYPE__'];
				unset( $result['__CTYPE__'] );
				
				// 2. 根据类型进行处理
				if( $ctype == 'cmerge' ){
					// 合并在一起
					$data = array_merge( $data, $result );
				}else{
					$data[$k] = $result;
				}
			}else{
				$data[$k] = $result;
			}
		}

		// 3) 返回结果
		return $this->newTrim($data);
	}
	/**
	 * 从内容中获取指定的元素
	 *
	 * @param str $html
	 * @param array $config 匹配数组，包含查找规则rule和替换规则replace
	 * @return str
	 */
	public function getItem( $html, $configs ){
		// 1) 验证配置匹配项
		if( !is_array( $configs ) ){
			return '';
		}
		
		// 2) 循环解析配置，同一数据项可解析多次完成匹配
		foreach ( $configs as $config ){
			if( isset( $config['match'] ) ){
				// 精确匹配
				$rule = $this->_replace_sg( $config['match'] );
				$html = $this->_cutHtml( $html, $rule[0], $rule[1] );
			}elseif( isset( $config['replace'] ) ){
				// 替换
				$html = $this->_replaceItem( $html, $config['replace'] );
			}elseif( isset( $config['method'] ) ){ 
				
				// 1. 执行方法，目前提供了五个 getImg getImgs(数组) match(串) matchAll(数组) matchAssign(用于循环每个元素的值,并且指定键)
				$method = $this-> _callMethod( $config['method'] );

				// 2. 方法不存在忽略
				if( !$method ){
					continue;
				}
				
				// 3. 执行方法
				$config['method'] = $html;// 这个要传递过去的,注意表示要调用的方法第一个参数都是要处理的内容
				$html = call_user_func_array( $method, $config );
			}
		}
		return $html;
	}
	/**
	 * 返回可调用的方法
	 *
	 * @param str | array $method
	 * @return str | array | null
	 */
	private function _callMethod( $method ){
		// 1) 验证合法
		if( !$method ){
			return null;
		}
		
		// 2) 若是可调用的直接返回
		if( is_callable( $method ) ){
			return $method;
		}
		
		// 3) 是不是本类的方法(要求不能与系统函数重名，否则上面就返回了)
		if( method_exists( $this, $method )){
			return array( $this, $method );
		}else{
			return null;
		}
	}
	/**
	 * 获取内容中所有img的src的链接
	 *
	 * @param str $html
	 * @return array
	 */
	public function getImgs( $html ){
		preg_match_all('/<img[^>]*src=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $html, $out);
		return $out[1];
	}
	/**
	 * 过滤函数：filter:返回单张图片
	 *
	 * @param str $html
	 * @return str url
	 */
	public function getImg( $html ){
		$images = $this->getImgs( $html );
		return is_array($images) ? $images[0] : '';
	}
	/**
	 * 过滤函数：filter:获取内容中所有A标签的href链接
	 *
	 * @param str $html
	 * @return array 
	 */
	public function getAs($html) {
		$html = $this->_transA($html);// 转换大小写并且可读性良好的格式
		preg_match_all('/<a[^>]*href=[\'"]?([^>\'"\s]*)[\'"]?[^>]*>/i', $html, $out);
		return $out[1];
	}
	/**
	 * 过滤函数：filter:获取内容中所有A标签中间的内容标题
	 *
	 * @param str $html
	 * @return array 
	 */
	public function getAsContent($html) {
		$html = $this->_transA($html);// 转换大小写并且可读性良好的格式
		preg_match_all('/<a[^>]*href=[^>]*>([^<>]*)<\/a>/i', $html, $out);
		return $out[1];
	}
	/**
	 * 即获取链接也获取标题
	 *
	 * @param str $html
	 * @return array[title,url]
	 */
	public function getAtag($html){
		$html = $this->_transA($html);
		return $this->_parseAtag($html);
	}
	/**
	 * 清除空格
	 *
	 * @param array | string $string
	 * @return string
	 */
	private function _newTrim($string){
		if(!is_array( $string ) ) return trim($string);
			foreach($string as $key => $val){ 
				$string[$key] = $this->_newTrim($val); 
			}
		return $string;
	}
	/**
	 * 分析A标签并去重,保留，先不这么实现了
	 */
	private function _parseAtag( $html ){
		preg_match_all('/<a([^>]*)>([^\/a>].*)<\/a>/i', $html, $out);
		$out[1] = array_unique($out[1]);
		$out[2] = array_unique($out[2]);
		if( !is_array( $out[1] ) ){
			return null;
		}
		$data = array();
		foreach ($out[1] as $k=>$v) {
			if (preg_match('/href=[\'"]?([^\'" ]*)[\'"]?/i', $v, $match_out)) {
				$data[$k]['url'] = $match_out[1];
				$data[$k]['title'] = strip_tags($out[2][$k]);
			}
		}
						
		return $data;
	}
	/**
	 * 正则匹配数据
	 *
	 * @param str $html
	 * @param str $regex 含一个括号的匹配项
	 * @return str
	 */
	public function match( $html, $regex ){
		preg_match( $regex, $html, $out);
		return $out[1];

	}
	/**
	 * 正则匹配数据
	 *
	 * @param str $html
	 * @param str $regex 含一个括号的匹配项
	 * @return array
	 */
	public function matchAll( $html, $regex ){
		preg_match_all( $regex, $html, $out );
		return $out[1];
	}
	/**
	 * 将匹配的项映射进去
	 *
	 * @param str $html
	 * @param str $regex 正则表达式，含一个括号的匹配项 '/<div[^>]*>([^<>]*)<\/div>/i', $data['temp_detail'], $out);
	 * @param array $kmap 键值对。匹配项位置=>需要的名称
	 * @return bool 是否映射成功
	 */
	public function matchAssign( $html, $regex, $kmap ){
		// 1) 匹配结果
		preg_match_all( $regex, $html, $out );
		$result = array('__CTYPE__'=>'cmerge');
		
		// 2) 映射到键里面去，以合并数据
		if( is_array( $out[1] ) ){
			foreach ( $kmap as $k=>$name ){
				$result[$name] = $out[1][$k];
			}
			return $result;
		}else{
			return null;
		}
	}
	/**
	 * 替换函数：replace:替换元素中多余的
	 *
	 * @param str $html 内容
	 * @param array $config 替换 中间以[|]做为分隔符的数组，可替换多次,支持正则
	 * @return str
	 */
	private  function _replaceItem($html, $config) {
		// 1) 验证匹配项
		if (empty($config)){
			return $html;
		}
		
		// 2) 循环匹配 
		$patterns = $replace = array();
		foreach ($config as $k=>$v) {
			$c = explode('[|]', $v);
			$patterns[$k] = '/'.str_replace('/', '\/', $c[0]).'/i';
			$replace[$k] = $c[1];
		}
		return  preg_replace($patterns, $replace, $html);
	}
	/**
	 * HTML夹取:精确匹配
	 * @param $html 内容
	 */
	private function _replace_sg($html) {
		$list = explode('[内容]', $html);
		if (is_array($list)) foreach ($list as $k=>$v) {
			$list[$k] = str_replace(array("\r", "\n"), '', trim($v));
		}
		return $list;
	}
	/**
	 * 
	 * HTML夹取:掐头去尾保留中间
	 * @param string $html    要进入切取的HTML代码
	 * @param string $start   开始	页面中不能有重复
	 * @param string $end     结束	页面中不能有重复
	 */
	private  function _cutHtml($html, $start, $end) {
		// 1) 验证并且去除换行符
		if (empty($html)){ 
			return '';
		}
		$html = str_replace(array("\r", "\n"), "", $html);
		$start = str_replace(array("\r", "\n"), "", $start);
		$end = str_replace(array("\r", "\n"), "", $end);
		
		// 2) 头分隔，尾分隔，即可取出中间的内容
		$html = explode(trim($start), $html);
		if(is_array($html)){
			$html = explode(trim($end), $html[1]);
		}
		
		// 3) 去掉html注释内容
		return preg_replace('/<!--(.*?)-->/i','',$html[0]);  //有可能出现两次注释	故要禁止贪婪
	}
	/**
	 * 转换A标签成小写可读形式
	 */
	private function _transA( $html ){
		$html = str_replace(array("\r", "\n"), '', $html);
		$html = str_replace(array("</a>", "</A>"), "</a>\n", $html);
		return $html;
	}
	/**
	 * 去除所有空格
	 *
	 * @param str | array $string
	 * @return str | array
	 */
	public function newTrim($string){
		if(!is_array($string)) return trim($string);
		foreach($string as $key => $val){ 
			$string[$key] = $this->newTrim($val); 
		}
		return $string;
	}
}