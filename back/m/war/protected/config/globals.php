<?php

//建立文件夹
function makedir($param) {
	if(!file_exists($param)) {
		makedir(dirname($param) );
		mkdir($param);
	}
}
/**
 * 有效数组验证
 *
 * @param array $arr
 * @return bool
 */
function valid_array( &$arr ){
	if( !is_array($arr) || empty($arr) ){
		return false;
	}else{
		return true;
	}
}
/**
 * 取出查询结果集里面的id
 *
 * @param array $rows
 * @param str $id
 * @return array | null
 */
function onlyIds( &$rows, $id = 'id',$trimempty=false){
	if( empty($rows) ){
		return null;
	}
	$ids = array();
	foreach ( $rows as $row ){
		if( $trimempty ){
			if( intval($row[$id]) > 0){
				$ids[] = $row[$id];
			}
		}else{
			$ids[] = $row[$id];
		}
	}
	return $ids;
}
/**
 * 将提交的id转换成纯数字的id:可能有两种形式一种是数组，一种是字符串
 *
 * @param str | array $c, 字符串要求是','分隔
 */
function toIds( $ids ){
	if( !is_array($ids) ){
		$ids = explode( ',', $ids );
	}
	foreach ( $ids as $k=>$id ){
		if( !is_numeric( $id )){
			unset( $ids[$k] );
		}
	}
	return $ids;
}
/**
 * 给一个数组中的元素两边加上单引号
 */
function addQuote( $array, $n = "'" ){
    if( is_array($array) ){
        $str = implode("{$n},{$n}", $array);
		return "{$n}".$str."{$n}";
    }else{
        return $array;
    }
}
/**
 * 两个数组根据某键合并在一起
 *
 * @param array $rows1 引用传值，避免复制
 * @param array $rows2 引用传值，避免复制
 * @param str $id 两数组关联键
 * @param bool $once 仅匹配一次
 * @return array
 */
function appends( &$rows1, &$rows2, $id = 'id', $once = true){
	if( !is_array($rows1) || empty( $rows1 ) ){
		return null;
	}
	if( !is_array($rows2) || empty( $rows2 ) ){
		return $rows1;
	}
	foreach ( $rows1 as &$row1){
		foreach ( $rows2 as $k2=>$row2){
			if($row1[$id] == $row2[$id]){
				$row1 = array_merge($row1,$row2);
				if( $once ){
					unset( $rows2[$k2] );
				}
			}
		}
	}
	return $rows1;
}
/**
 * 递归去空格函数
 *
 * @param  array | string $string
 * @return array | string
 */
function new_trim($string){
	if(!is_array($string)) return trim($string);
	foreach($string as $key => $val){ 
		$string[$key] = new_trim($val); 
	}
	return $string;
}
/**
 * 去除html的空格
 */
function del_nbsp($string){
	if(!is_array($string)){
		$string = htmlentities($string);
    	$string = str_replace('&nbsp;','',$string);
    	return $string;
  	}
  	foreach($string as $key => $val){ 
    	$string[$key] = del_nbsp($val); 
    }
	return $string;
}
/**
 * 返回经addslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_addslashes($string){
	if(!is_array($string)) return addslashes($string);
	foreach($string as $key => $val) $string[$key] = new_addslashes($val);
	return $string;
}
/**
 * 返回经stripslashes处理过的字符串或数组
 * @param $string 需要处理的字符串或数组
 * @return mixed
 */
function new_stripslashes($string) {
	if(!is_array($string)) return stripslashes($string);
	foreach($string as $key => $val) $string[$key] = new_stripslashes($val);
	return $string;
}
function new_htmlspecialchars($string) {
	if(!is_array($string)) return htmlspecialchars($string);
	foreach($string as $key => $val) $string[$key] = new_htmlspecialchars($val);
	return $string;
}
/**
	 * 通过城市id获取该城市区域，因该接口需要设置header，暂分离开
	 *
	 * @param	string	$url		接口地址
	 * @param	array	$args		方法所用参数
	 * @param	string	$method		接口调用方式
	 * @param	int		$timeout	最大超时时间
	 * @return	all_type
	 */
function callCity_zone($url, $args = array(), $method = 'GET', $timeout = 5) {
		$method = strtoupper($method);
		if ($method != 'POST') {
			foreach($args as $key=>$value) { 
				$url .= strpos($url, '?') ? '&'.$key.'='.$value : '?'.$key.'='.$value;
			}
		}
		$header = md5('cityId='.$args['cityId'].'e0cd45bf9ee7773cc9b72bd824f3b35c');
		$headers = array("sign:".$header);
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ci, CURLOPT_URL, $url);
		$result = curl_exec($ci);
		$errno = curl_errno($ci);
		$errmsg = curl_error($ci);
		//echo $url;
		//echo $result;
		curl_close($ci);	
		$result = json_decode($result,true);
		if(!is_array($result) || (isset($result['errorCode']) && $result['errorCode'] == 1)){
			return false;
		}	
		return $result;
}
/**
 * 通用curl 返回json
 * @param str $url
 * @param array $args
 * @param str $method GET | POST
 * @param int $timeout
 * @return array
 */
function curlJson( $url, $args = array(), $method = 'GET', $timeout = 5, $headers = '' ){
	$ci = curl_init();
	$method = strtoupper($method);
	if( is_array($args) ){
		if ($method == 'POST') {
			$formdata = http_build_query($args);
			curl_setopt($ci, CURLOPT_POST, true);
			curl_setopt($ci, CURLOPT_POSTFIELDS, $formdata);
		}else{
			foreach($args as $key=>$value) { 
				$url .= strpos($url, '?') ? '&'.$key.'='.$value : '?'.$key.'='.$value;
			}
		}
	}
	$useragent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; focus_user_center)';
	curl_setopt($ci, CURLOPT_USERAGENT, $useragent);
    if ( $headers )
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers); 
	curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
	curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ci, CURLOPT_URL, $url);
	$result = curl_exec($ci);
	$errno = curl_errno($ci);
	$errmsg = curl_error($ci);
	//echo $url;
	//echo $result;
	curl_close($ci);	
	$result = json_decode($result,true);
	if(!is_array($result)){
		return null;
	}	
	return $result;
}

/**
 * 以excel导出
 * @param str $title 标题
 * @param array $header 表名
 * @param array $data 二维数据
 * @param array $headerSize 表头尺寸
 */
function excelOut( $title, $header, $data, $headerSize=null ){
	// 1 输出头
	header('Content-Type : application/vnd.ms-excel');
	header('Content-Disposition:attachment;filename="'.$title.'.xls"');
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header('Content-Disposition:attachment;filename="'.$title.'.xls"');
	header("Content-Transfer-Encoding:binary");

	// 2 创建excel
	$objectPHPExcel = new PHPExcel();
	$objectPHPExcel->setActiveSheetIndex(0);
	$sheet = $objectPHPExcel->getActiveSheet();
	$sheet->setTitle($title);

	// 3 表头
	if( is_array($header) ){
		foreach ( $header as $i=>$v ){
			// 1 表头标题
			$litter = chr( $i + 65 ) ;
			$colName = $litter . '1';
			$sheet->setCellValue( $colName , $v[0] );
			
			// 2 设置左对齐
			$sheet -> getStyle($colName) -> getAlignment() -> setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
			
			// 3 列尺寸
			if($v[1]){
				$sheet->getColumnDimension($litter)->setWidth($v[1]);
			}else{
				$sheet->getColumnDimension($litter)->setAutoSize(true);
			}
		}
	}

	// 4 内容
	$row=2;
	if( is_array($data) ){
		foreach($data as $item){
			// 单行
			$col=0;
			foreach ( $item as $v ){
				// 设置值
				$colName = chr($col+65) . $row;
				$sheet->setCellValue( $colName , $v );
				// 设置左对齐
				$sheet -> getStyle($colName) -> getAlignment() -> setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
				$col ++;
			}
			// 下一行
			$row ++; 
		}
	}
	// 6 输出
	$objWriter= PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
	$objWriter->save('php://output');
}
/**
 * 以csv导出
 * @param str $title 标题
 * @param array $header 表名
 * @param array $data 二维数据
 * @param array $headerSize 表头尺寸
 */
function csvOut( $title, $header, $data ){
    header("Content-type:application/vnd.ms-excel");
    header("content-Disposition:filename={$title}.csv ");
    foreach ($header as $vt){
        $vt = iconv('UTF-8', 'GBK', $vt[0]);
        echo "{$vt},";
    }
    echo "\n";
    foreach ( $data as $vc){
        foreach ($vc as $vv){
            $vv = str_replace(',','，',$vv); //去除英文逗号，改成中文，防止和csv换tab标记冲突
            $vv = iconv('UTF-8', 'GBK', $vv);
            echo "{$vv},";
        }
        echo "\n";
    }
}
/**
* 提示信息
*/
function message( $action = 'success', $content = '', $redirect = 'javascript:history.back(-1);', $timeout = 4 ) {
   switch ( $action ) {
   case 'success':
       $titler = '操作完成';
       $class = 'message_success';
       $images = 'message_success.png';
       break;
   case 'error':
       $titler = '操作未完成';
       $class = 'message_error';
       $images = 'message_error.png';
       break;
   case 'errorBack':
       $titler = '操作未完成';
       $class = 'message_error';
       $images = 'message_error.png';
       break;
   case 'redirect':
       header( "Location:$redirect" );
       break;
   case 'script':
       if ( empty( $redirect ) ) {
           exit( '<script language="javascript">alert("' . $content . '");window.history.back(-1)</script>' );
       } else {
           exit( '<script language="javascript">alert("' . $content . '");window.location=" ' . $redirect . '   "</script>' );
       }
       break;
   }

   // 信息头部
   $header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>操作提示</title>
<style type="text/css">
body{font:12px/1.7 "\5b8b\4f53",Tahoma;}
html,body,div,p,a,h3{margin:0;padding:0;}
.tips_wrap{ background:#F7FBFE;border:1px solid #DEEDF6;width:780px;padding:50px;margin:50px auto 0;}
.tips_inner{zoom:1;}
.tips_inner:after{visibility:hidden;display:block;font-size:0;content:" ";clear:both;height:0;}
.tips_inner .tips_img{width:80px;float:left;}
.tips_info{float:left;line-height:35px;width:650px}
.tips_info h3{font-weight:bold;color:#1A90C1;font-size:16px;}
.tips_info p{font-size:14px;color:#999;}
.tips_info p.message_error{font-weight:bold;color:#F00;font-size:16px; line-height:22px}
.tips_info p.message_success{font-weight:bold;color:#1a90c1;font-size:16px; line-height:22px}
.tips_info p.return{font-size:12px}
.tips_info .time{color:#f00; font-size:14px; font-weight:bold}
.tips_info p a{color:#1A90C1;text-decoration:none;}
</style>
</head>
<body>';
   // 信息底部
   $footer = '</body></html>';
   $body = '<script type="text/javascript">
   function delayURL(url) {
   var delay = document.getElementById("time").innerHTML;
   //alert(delay);
   if(delay > 0){
   delay--;
   document.getElementById("time").innerHTML = delay;
} else {
window.location.href = url;
}
setTimeout("delayURL(\'" + url + "\')", 1000);
}
</script><div class="tips_wrap">
<div class="tips_inner">
   <div class="tips_img">
       <img src="' . Yii::app()->baseUrl . '/images/' . $images . '"/>
   </div>
   <div class="tips_info">
       <p class="' . $class . '">' . $content . '</p>
       <p class="return">系统自动跳转在  <span class="time" id="time">' . $timeout . ' </span>  秒后，如果不想等待，<a href="' . $redirect . '">点击这里跳转</a></p>
   </div>
</div>
</div><script type="text/javascript">
delayURL("' . $redirect . '");
</script>';
   exit( $header . $body . $footer );
}

/**
 * 获取登录信息
 * @param type $key
 * @return array
 */
function get_sohu_passport($key = null) {
//        return array("userid"=>'qx','username'=>13581524051,'domain'=>'test'); 
		$passport = array();
		$headers = apache_request_headers();
		$passport_userid = $headers['X-SohuPassport-UserId'];
		if (!preg_match("/(.+)@(.+)$/", $passport_userid, $passport_info)) {
			return null;
		}
		$passport["userid"] = $passport_userid;
		$passport["domain"] = $passport_info[2];
		$passport["username"] = $passport_info[1];
		
		if ($key) {
			return $passport[$key];
		}
		return $passport;
	}


/**
 * 字符串替换
 * strReplace('13812341210', '*', 3, 4)  //  return 138****1210
 */
function strReplace( $str, $replace = '*', $start = 3, $lenght = 4 ){
    for( $i=1; $i<=$lenght; $i++){
        $rep .=$replace;
    }
    if( $str ){
        return substr_replace($str, $rep, $start, $lenght);
    }else{
        return ;
    }
    
}
/**
 * 不用了： 根据用户权限获取用户城市
 * @param type $userinfo
 * @return type
 */
function accountCity($userinfo){
    if( $userinfo ){
        if( trim($userinfo['typestr']) === 'all'){ //超级管理员
            return HConfig::city();
        }else{ //普通用户
            return array($userinfo['city_id']=>"{$userinfo['city_name']}");
        }
    }else{
        return false;
    }
}
/**
* 验证手机号码
*/
function is_mobile( $str ) {
   if ( empty( $str ) ) {
       return false;
   }
   return preg_match( '#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $str );
}
/**
 * 老数据库配置成 charset=>'latin1'
 */
function latindb2utf8($string){
	if( !is_array($string )){
		//$string = iconv('utf-8','latin1',$string);// 这句不要了
		$string   = iconv('gbk','utf-8',$string);
		return $string;
	}
	foreach($string as $key => $val){ 
		$string[$key] = latindb2utf8($val); 
	}
	return $string;
}

// 用于测试
function print_test($rows){
	echo '<pre>';
	var_export($rows);
	echo '</pre>';
}

/**
 * UTF-8中截取字符串函数，为了解决截取汉字出现乱码问题。
 *
 * @param unknown_type $string 被截取的字符串
 * @param unknown_type $length 要截取的长度
 * @param unknown_type $etc 末尾替代省略字符串的符号
 */
function substr_utf8_cn($string, $length, $etc = '...') {
	$result = '';
	$string = html_entity_decode ( trim ( strip_tags ( $string ) ), ENT_QUOTES, 'UTF-8' );
	$strlen = strlen ( $string );
	for($i = 0; (($i < $strlen) && ($length > 0)); $i ++) {
		if ($number = strpos ( str_pad ( decbin ( ord ( substr ( $string, $i, 1 ) ) ), 8, '0', STR_PAD_LEFT ), '0' )) {
			if ($length < 1.0) {
				break;
			}
			$result .= substr ( $string, $i, $number );
			$length -= 1.0;
			$i += $number - 1;
		} else {
			$result .= substr ( $string, $i, 1 );
			$length -= 0.5;
		}
	}
	$result = htmlspecialchars ( $result, ENT_QUOTES, 'UTF-8' );
	if ($i < $strlen) {
		$result .= $etc;
	}
	return $result;
}
/**
 * 采集类较完整的
 *
 * @param str $url
 * @param array $data post数据
 * @param int $timeout 秒数
 * @param str $cookie_file 保存cookie的文件
 * @param str $userAgent
 * @return str
 */
function curl($url, $data=array(), $timeout=10, $cookie_file='', $userAgent='', $refer='' ){
	// 1 cookie值
	if( !$cookie_file ){
		$cookie_file =  dirname(__FILE__).'/cookie.txt';  
	}

	// 2 实例化采集
	$ch = curl_init($url);
	//curl_setopt($ch, CURLOPT_URL, $url);
	
	// 3 参数设置
	curl_setopt( $ch, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
	// 注掉apache的 才可以用下面的指令 php_admin_value open_basedir "d:\;C:\Windows\Temp;"
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,1); // 使用自动跳转
	//curl_setopt( $ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
	curl_setopt ($ch,CURLOPT_REFERER,$refer);
	
	
	// 4 设置超时
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	
	// 5 设置返回的串，而不是输出
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	// 6 post提交地址
	if ( is_array($data) && !empty($data) ) {
		$formdata = http_build_query($data);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
	}

	// 7 userAgent
	if($userAgent){
		curl_setopt($ch,CURLOPT_USERAGENT,$userAgent);
	}else{
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:28.0) Gecko/20100101 Firefox/28.0");
	}
	
	// 8 cookie 
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);	// 存放Cookie信息的文件名称
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); // 读取上面所储存的Cookie信息
	
	
	
	// 9 ssl https
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	
	// 10 开始执行采集
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
