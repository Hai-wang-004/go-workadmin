<?php
/**
 * 用于手机点击下一页的精简单分页类
 * @author lijin
 *
 */
class MPage extends CController {
	/**
	 * @var int 当前页
	 */
	private $curPage;
	
	/**
	 * @var int 每页数量
	 */
	private $perPageNum;
	
	/**
	 * 初始化设置
	 * @var int $perPageNum
	 */
	public function __construct( $perPageNum=5 ){
		// 1 当前页 索引用0开始
		$curPage       = intval( $_GET['page'] );
		$this->curPage = $curPage > 0 ? $curPage : 0;
		
		// 2 每页数量
		$this->perPageNum = intval($perPageNum);
	}
	/**
	 * 获取分页偏移
	 */
	public function getLimit(){
		// 用于mysql的数据查询偏移
		$limit = $this->perPageNum;
		$offset= $this->curPage * $limit;
		if( $limit < 0 ){
			$limit = 0;
		}
		if( $offset < 0 ){
			$offset = 0;
		}
		return array($offset, $limit);
	}
	/**
	 * 判断是否是最后一页
	 */
	public function isPageEnd( $total ){
		// 1 计算当前能容纳的数据总量
		$ptotal = ($this->curPage + 1) * $this->perPageNum;
		
		// 2 返回是否可达最后一页
		return $ptotal >= $total ? true : false;
	}
	/**
	 * 获取当前页码
	 */
	public function getPage(){
		return $this->curPage;
	}
	
}
