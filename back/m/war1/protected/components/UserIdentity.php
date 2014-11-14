<?php
/**
 * @abstract 自定义用户校验类
 * @author yuntaohu@sohu-inc.com
 *
 */
class UserIdentity extends CUserIdentity {
	public $username;
	public $password;
	//private $_id;
	public $user;
	/**
	 * 从接口中获取数据
	 */
	private function getApi( $username, $password ){
		$url  = "http://soap.esf.focus.cn/Focus/UserCheck/?dataType=json&";
		$url .= "username={$username}&passwd={$password}"; 
		$data = curlJson($url);
		
		if( is_array($data) && $data['code'] == 1 ){
			return true;
		}else{
			return false;
		}
	}
	/**
	 * 校验用户登陆是否满足条件
	 *
	 * @return int
	 */
	public function authenticate() {
		// 1 获取接口中的数据
		$result = $this->getApi($this->username, $this->password);
		//$result = $this->getApi('mozheng', '111111');// debug;
		
		// 2 验证本地数据库
		if( $result ){
			$data = User::model() -> getByName($this->username);
			if( is_array( $data ) && $data['power'] == 8 ){
				// 当用户有效时
				$this->user = $data;
				$this->errorCode = self::ERROR_NONE;
			}else{
				// 无效用户,可能权限不足
				$this->errorCode = self::ERROR_USERNAME_INVALID; 
			}
		}else{
			// 没有该帐号
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}
		
		return !$this->errorCode;
	}
 
	/**
	 * 获取唯一标识符
	 * @author libo<neroli@sohu-inc.com>
	 */
	/*public function getId() {
		return $this->_id;
	}*/
	public function getPersistentStates(){
		return array('user'=>$this->user);
	}
}