<?php
/**
 * @abstract 自定义数据中间层，可以通过数组的形式执行数据库的增删改查
 * @author yuntaohu@sohu-inc.com
 * 
 */
class ActiveRecord extends CActiveRecord {
	private $prepare = '';
	private $params = array();
	
	/**
	 * 重置解析条件参数
	 *
	 */
	private function _resetParams()
	{
		$this->prepare = '';
		$this->params = array();
	}
	
	/**
	 * 自定义插入数据函数
	 *
	 * @param array $data
	 * @return int
	 */
	public function rInsert($data, $is_verify = false)
	{
		foreach ( $data as $k => $v )
			$this->$k = $v;
		$this->_new = true;
		$this->save($is_verify);
		return $this->getPrimaryKey();
	}
	
	/**
	 * 自定义更新数据函数
	 *
	 * @param array $condition 条件数组
	 * @param array $data 更新数据
	 * @return int
	 */
	public function rUpdate($condition, $data)
	{
		$this->_resetParams();
		$this->_buildCondition($condition);
		$criteria = new CDbCriteria();
		$criteria->condition = $this->prepare;
		$criteria->params = $this->params;
		Yii::trace(get_class($this).'.updateAll()','system.db.ar.CActiveRecord');
		$builder=$this->getCommandBuilder();
		$criteria=$builder->createCriteria($criteria, array());
		$command=$builder->createUpdateCommand($this->getTableSchema(),$data,$criteria);
		return $command->execute();
	}
	
	/**
	 * 自定义删除数据函数
	 *
	 * @param array $id 条件数组
	 * @return int
	 */
	public function rDelete($condition)
	{
		$this->_resetParams();
		$this->_buildCondition($condition);
		$criteria = new CDbCriteria();
		$criteria->condition = $this->prepare;
		$criteria->params = $this->params;
		Yii::trace(get_class($this).'.deleteAll()','system.db.ar.CActiveRecord');
		$builder=$this->getCommandBuilder();
		$criteria=$builder->createCriteria($criteria, array());
		$command=$builder->createDeleteCommand($this->getTableSchema(),$criteria);
		return $command->execute();
	}
	
	/**
	 * 自定义根据条件数组获取单条数据方法
	 *
	 * @param array $condition 查询条件数组
	 * @return array
	 */
	public function getOne($condition = array())
	{
		$this->_resetParams();
		$this->_buildCondition($condition);
		$criteria = new CDbCriteria();
		$criteria->condition = $this->prepare;
		$criteria->params = $this->params;
		$criteria->offset = 0;
		$criteria->limit = 1;
		$result = $this->query($criteria);
		return empty($result) ? array() : $result->attributes;
	}
	
	/**
	 * 自定义根据条件数组获取满足条件的所有记录
	 *
	 * @param array $condition 查询条件数组
	 * @param string 排序条件
	 * @param int 起始位置
	 * @param int 查询长度
	 * @param string 查询字段
	 * @return array
	 */
	public function getAll($condition = array(), $order = '', $offset = -1, $size = -1, $select = '*')
	{
		$this->_resetParams();
		$this->_buildCondition($condition);
		$criteria = new CDbCriteria();
		$criteria->condition = $this->prepare;
		$criteria->params = $this->params;
		$criteria->select = $select;
		$criteria->offset = $offset;
		$criteria->limit = $size;
		$criteria->order = $order;
		return array_map(create_function('$record','return $record->attributes;'), $this->query($criteria,true));
	}
	
	/**
	 * 自定义根据条件数组获取满足条件的所有记录数
	 *
	 * @param array $condition
	 * @return int
	 */
	public function getCount($condition = array())
	{
		$this->_resetParams();
		$this->_buildCondition($condition);
		$criteria = new CDbCriteria();
		$criteria->condition = $this->prepare;
		$criteria->params = $this->params;
		return parent::count($criteria);
	}
	
	/**
	 * 根据数组构造预编译和参数函数
	 * 
	 * @param $condition 条件数组
	 * @param 连接符
	 * 
	 * 
	 */
	private function _buildCondition(array $condition = array(), $logic='AND'){
		if ( is_string( $condition ) || is_null($condition) ) return $condition;
		$logic = strtoupper( $logic );
		$content = null;
		foreach ( $condition as $k => $v ) {
			$v_str = ' ? ';
			$v_connect = '=';

			if ( is_numeric($k) ) {
				$content .= ' '. $logic . ' (' . $this->_buildCondition( $v ) . ')';
				continue;
			}

			$maybe_logic = strtoupper($k);
			if ( in_array($maybe_logic, array('AND','OR','BINARY'))) {
			    if($maybe_logic == 'BINARY') {
					$content .= $logic . '  BINARY  ' . $this->_buildCondition( $v, $maybe_logic ) . '';
				} else {
					$content .= $logic . ' (' . $this->_buildCondition( $v, $maybe_logic ) . ')';
				}
				continue;
			}

			if ( is_numeric($v) ) {
				$this->params[] = $v;	
			} else if ( is_null($v) ) {
				$v_connect = ' IS ';
				$v_str = 'NULL';
			} else if ( is_array($v) && ($c = count($v))) {
			    $types = array('<', '<=', '>', '>=', '<>', '!=');
				$v_keys = array_keys($v);
				$over = false;
				foreach ($v_keys as $tmp_v_k => $tmp_v_v){
					if ( in_array($tmp_v_v, $types, 1) ){
					    $v_connect = $tmp_v_v;
					    $v_str = $v[$tmp_v_v];
					    $over = true;
						$content .= " $logic `$k` $v_connect ? ";
						$this->params[] = $v_str;
					}
				}
				if ($over) continue;
				if (1<$c) {
					$this->params = array_merge($this->params, $v);
					$v_connect 	= 'IN (' . join(',', array_fill(0, $c, '?')) . ')';
					$v_str		= '';
				} else if ( empty($v) ) {
					$v_str = $k;
					$v_connect = '<>';
				} else {
					$tmp_keys = array_keys($v);
					$v_connect = array_shift($tmp_keys);
					if( is_numeric($v_connect) )
						$v_connect = '=';
					$tmp_values = array_values($v);	
					$v_s = array_shift($tmp_values);

					if(is_array($v_s)) {
						$v_str = 'IN (' . join(',', array_fill(0, count($v_s), '?')) . ')';
						$this->params = array_merge($this->params, $v_s);
					} else {
						$this->params[] = $v_s;	
					}

				}
			} else {
				$this->params[] = $v;
			}
			$content .= " $logic `$k` $v_connect $v_str ";
		}
		$content = preg_replace( '/^\s*'.$logic.'\s*/', '', $content );
		$content = preg_replace( '/\s*'.$logic.'\s*$/', '', $content );
		$content = trim($content);
		$this->prepare = $content;
		return $content;
	}
}
