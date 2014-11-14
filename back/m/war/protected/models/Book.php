<?php
/**
 * 这个是表 "{{booking}}" 的模型类
 *
 * 表 '{{booking}}' 的字段如下:
 * @property integer $bid
 * @property integer $broker_id
 * @property integer $agent_id
 * @property integer $sector_id
 * @property integer $company_id
 * @property integer $city_id
 * @property string $name
 * @property string $idcard
 * @property string $phone
 * @property integer $house_id
 * @property integer $booking_date
 * @property integer $booking_hour
 * @property integer $over_time
 * @property integer $create_time
 * @property integer $status
 */
class Book extends ActiveRecord
{
	/**
	 * @return string 表名
	 */
	public function tableName()
	{
		return '{{booking}}';
	}

	/**
	 * @return array 模型属性规则验证
	 */
	public function rules()
	{
		// NOTE: 你应该仅仅 为用户输入的属性 定义这些规则
		return array(
			array('name, phone', 'required'),
			array('broker_id, agent_id, sector_id, company_id, city_id, house_id, booking_date, booking_hour, over_time, create_time, status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('idcard', 'length', 'max'=>20),
			array('phone', 'length', 'max'=>15),
			// 下面的 search() 方法可以使用这些规则
			// @todo 移除不需要的属性
			array('bid, broker_id, agent_id, sector_id, company_id, city_id, name, idcard, phone, house_id, booking_date, booking_hour, over_time, create_time, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 表关联规则
	 */
	public function relations()
	{
		// NOTE: 你可能需要调整表关联名称，下面的表之间关系是自动生成的。
		return array(
		);
	}

	/**
	 * @return array 定制属性说明 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bid' => '预约ID,主键，自增',
			'broker_id' => '用户id',
			'agent_id' => 'Agent',
			'sector_id' => 'Sector',
			'company_id' => 'Company',
			'city_id' => 'City',
			'name' => '姓名',
			'idcard' => '身份证号',
			'phone' => '姓名',
			'house_id' => '楼盘ID',
			'booking_date' => '预约时间',
			'booking_hour' => '预约时间具体到1-24时',
			'over_time' => '过期时间',
			'create_time' => '创建预约时间',
			'status' => '0未带看 1已带看',
		);
	}

	/**
	 * 获取基于 search/filter 的属性列表
	 *
	 * 经典用例:
	 * - 从过滤的form中 初始化该模型的字段与值
	 * - 执行本方法 以获取 CActiveDataProvider 的实例
	 * - 传递这些数据给 CGridView, CListView 或任何相似 widget
	 *
	 * @return CActiveDataProvider 返回一个数据提供者:基于 search/filter 的模型
	 */
	public function search()
	{
		// @todo 请修改下面的代码以移除你不需要查询的属性.
		
		$criteria=new CDbCriteria;

		$criteria->compare('bid',$this->bid);
		$criteria->compare('broker_id',$this->broker_id);
		$criteria->compare('agent_id',$this->agent_id);
		$criteria->compare('sector_id',$this->sector_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('idcard',$this->idcard,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('house_id',$this->house_id);
		$criteria->compare('booking_date',$this->booking_date);
		$criteria->compare('booking_hour',$this->booking_hour);
		$criteria->compare('over_time',$this->over_time);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 返回该类静态模型
	 *
	 * @param string $className 该类名
	 * @return Book2 静态模型类
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 验证是否过期
	 * 即查找此当前时间后是否有同手机同楼盘的数据
	 * 
	 */
	public function chkOverTime( $phone, $house_id ){
		$condition = array(
			'phone' 	=> $phone,
			'house_id'  => $house_id,
			'over_time' => array('>=' => strtotime( date('Y-m-d H:00:00') ) ),// 当前时间，精确到小时
		);
		$data = $this->getCount( $condition );
		return  $data > 0;
	}
}
