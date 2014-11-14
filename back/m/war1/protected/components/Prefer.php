<?php
/**
 *  偏好
 */
class Prefer{
	/**
	 * 单例
	 */
	private static $_instance;
	/**
	 * 偏好数据
	 */
	private $data;
	private function __construct(){
		$this->data = Yii::app()->params['wow_prefer'];
	}
	/**
	 * 单例模式
	 */
	public static function model(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self;
		}
		return self::$_instance;
	}
	public function getData(){
		return $this->data;
	}
	/**
	 * 是否达到通知购买的条件
	 * @var int $itemId 商品id
	 * @var int $per 单价
	 */
	public function isNotice( $itemId, $per ){
		if( !$per ){
			// 这种肯定有问题
			return false;
		}
		$data = &$this->data;
		
		if( $itemId && isset( $data[$itemId] ) && $data[$itemId]['noticeValue'] ){
			$noticeValue = intval($data[$itemId]['noticeValue']);
		}else{
			$noticeValue = 0;
		}
		return $noticeValue / 20 >= $per ? true : false;
	}
	
}

