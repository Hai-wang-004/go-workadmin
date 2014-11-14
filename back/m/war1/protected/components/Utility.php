<?php
/**
 * @abstract 全站静态方法调用
 * @author lostsun 
 * @lastModify By Yuntaohu 2011-03-04
 */
class Utility{
	
	//格式化秒数为天时分秒
	public static function vtime($time) {
	  $output = '';
	  foreach (array(86400 => '天', 3600 => '时', 60 => '分', 1 => '秒') as $key => $value) {
	    if ($time >= $key) $output .= floor($time/$key) . $value;
	    $time %= $key;
	  }
	  return $output;
	}

	
	//是否是手机号
	public static function isPhone($str = ''){
		$flag = false;
		$str = trim($str);
		$pattern = "/^[1]\d{10}$/";
		if (preg_match($pattern,$str)) {
			$flag = true;
		}
		return $flag;
	}
	//过滤用户输入
	public static function verify($str = ''){
		$str = stripcslashes(trim($str));
	    $farr = array(
	        "/\s /", //过滤多余的空白
	        "/<(\/?)(script|i?frame|style|html|body|title|link|meta\?|\%)([^>]*?)>/isU", //过滤 <script 等可能引入恶意内容或恶意改变显示布局的代码,假如不需要插入flash等,还可以加入<object的过滤
	        "/(<[^>]*)on[a-zA-Z] \s*=([^>]*>)/isU", //过滤javascript的on事件	
	    );
	    $tarr = array(
	        " ",
	        "＜\\1\\2\\3＞", //假如要直接清除不安全的标签，这里可以留空
	        "\\1\\2",
	    );
	    $str = preg_replace( $farr,$tarr,$str);	
	    //过滤on事件lang js
	    while(preg_match('/(<[^><]+)(lang|onfinish|onmouse|onexit|onerror|onkey|onload|onchange|onfocus|onblur)[^><]+/i',$str,$mat)) {
	        $str=str_replace($mat[2],"xyz",$str);
	    }	
	    return $str;
	}
	/**
	 * 递归验证所有
	 * @var str|array $string 
	 */
	public static function verifys($string){
		if(!is_array($string)){
			return self::verify($string);
		}
		foreach($string as $key => $val){
			$string[$key] = self::verifys($val);
		}
		return $string;
	}
	
	/**
	 * json encode函数
	 *
	 * @param array $data
	 * @return string
	 */
	public static function Encode($data)
	{
		if ( version_compare(phpversion(), '5.4') < 0 ) {
			$json = json_encode($data);
			$json = preg_replace("#\\\u([0-9a-f]{4}+)#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $json);
		} else {
			$json = json_encode($data, JSON_UNESCAPED_UNICODE);
		}
		return $json;
	}
	
	/**
	 * json decode函数
	 *
	 * @param string $data
	 * @return array
	 */
	public static function Decode($data)
	{
		return json_decode($data, true);
	}
}

