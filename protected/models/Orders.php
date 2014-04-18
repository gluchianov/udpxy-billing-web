<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $id
 * @property string $id_user
 * @property string $id_allowed
 * @property string $id_tvpack
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property string $start_operator
 * @property string $end_operator
 */
class Orders extends CActiveRecord
{
    const GET_ALLINFO=0;
    const GET_ONLYUSER=1;
    const GET_ONLYALLOWED=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_allowed, id_tvpack, start_date, end_date, status, start_operator, end_operator', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('id_user, id_allowed, id_tvpack, start_operator, end_operator', 'length', 'max'=>10),
			array('id, id_user, id_allowed, id_tvpack, start_date, end_date, status, start_operator, end_operator', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'tvpack'   => array(self::BELONGS_TO, 'Tvpack', 'id_tvpack'),
            'allowed'   => array(self::BELONGS_TO, 'AllowedList', 'id_allowed'),
            'user'      => array(self::BELONGS_TO, 'Clients', 'id_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_allowed'=>'Id Allowed list',
			'id_tvpack' => 'Id Tvpack',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'status' => 'Status',
			'start_operator' => 'Start Operator',
            'end_operator' => 'End Operator',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_user',$this->id_user,true);
		$criteria->compare('id_allowed',$this->id_allowed,true);
		$criteria->compare('id_tvpack',$this->id_tvpack,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('start_operator',$this->start_operator,true);
        $criteria->compare('end_operator',$this->end_operator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
//--------------------- My Methods ------------------------------------------

    /** Check actual orders function. */
    public static function CheckOrders(){
        Orders::model()->updateAll(array('status'=>0,'end_date'=>date("Y-m-d H:i:s"),'end_operator'=>0),'(status=1) AND (end_date<NOW())');
    }

    /**
     * Select all active orders for current client
     * @param string $client_ip Client IP Address
     * @param int $return_type Types of return result
     * @param string $groupby Group by column name
     * @return CActiveRecord[] All finded active orders
     */
    public function GetActiveOrders($client_ip='',$return_type=self::GET_ALLINFO,$groupby=''){

        switch ($return_type){
            case self::GET_ONLYUSER: $with_array=array('user'); break;
            case self::GET_ONLYALLOWED: $with_array=array('allowed'); break;
            default: $with_array=array('user','allowed'); break;
        }

        $criteria=new CDbCriteria();
        $criteria->with=$with_array;
        if($groupby!='') $criteria->group=$groupby;
        $criteria->addCondition('start_date<=NOW() AND end_date>=NOW()');
        $criteria->addCondition('status=1');

        $criteria2= new CDbCriteria();
        if ($return_type!=self::GET_ONLYALLOWED) $criteria2->addCondition('user.ip=:claddr');
        if ($return_type!=self::GET_ONLYUSER) $criteria2->addCondition('INET_ATON(allowed.ip_start)<=INET_ATON(:claddr) AND INET_ATON(allowed.ip_end)>=INET_ATON(:claddr)','OR');

        $criteria->mergeWith($criteria2);
        $criteria->params=array(':claddr'=>$client_ip);
        return $this->findAll($criteria);
    }

}
