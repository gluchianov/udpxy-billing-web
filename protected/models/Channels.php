<?php

/**
 * This is the model class for table "channels".
 *
 * The followings are the available columns in table 'channels':
 * @property string $id
 * @property string $ch_name
 * @property string $stream_type
 * @property string $stream_address
 * @property integer $params
 */
class Channels extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'channels';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ch_name, stream_type, stream_address, params', 'required'),
			array('ch_name', 'length', 'max'=>32),
			array('stream_type', 'length', 'max'=>10),
			array('stream_address', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ch_name, stream_type, stream_address, params', 'safe', 'on'=>'search'),
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
            'tariffs'=>array(self::MANY_MANY, 'Tariff',
                'tvpack_list(id_channel, id_tvpack)'),
            'tvpackids'=>array(self::HAS_MANY, 'TvpackList', 'id_channel'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ch_name' => 'Ch Name',
			'stream_type' => 'Stream Type',
			'stream_address' => 'Stream Address',
            'params'=>'Params',
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
		$criteria->compare('ch_name',$this->ch_name,true);
		$criteria->compare('stream_type',$this->stream_type,true);
		$criteria->compare('stream_address',$this->stream_address);
        $criteria->compare('params',$this->params);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TvpackList the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Add channel to database
     * @param $ch_name Channel name
     * @param $stream_type HTTP or UDP
     * @param $stream_address Stream url
     * @param $params
     * @return null|integer NULL or ID
     */
    public function AddChannel($ch_name,$stream_type,$stream_address,$params){
        $ch_name=str_replace(array("\r\n", "\r", "\n"),'', trim($ch_name));
        $channel=$this->findByAttributes(array('ch_name'=>$ch_name));
        if ($channel!=NULL){
            $channel->ch_name=$ch_name;
            $channel->stream_type=trim($stream_type);
            $channel->stream_address=str_replace(array("\r\n", "\r", "\n"),'', trim($stream_address));
            $channel->params=$params;
            $channel->save();
            if($channel->save())
                return $channel->id;
        }else{
            $newchanel = new Channels();
            $newchanel->ch_name=$ch_name;
            $newchanel->stream_type=trim($stream_type);
            $newchanel->stream_address=str_replace(array("\r\n", "\r", "\n"),'', trim($stream_address));
            $newchanel->params=$params;
            if($newchanel->save())
                return $newchanel->id;
            else return NULL;
        }
    }
}
