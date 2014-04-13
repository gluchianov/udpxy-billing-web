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
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
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
            'tvpack'   => array(self::BELONGS_TO, 'TvPack', 'id_tvpack'),
            'allowed'   => array(self::BELONGS_TO, 'AllowedList', 'id_allowed'),
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
}
