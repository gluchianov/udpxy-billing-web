<?php

class Operator extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'operators':
	 * @var integer $id
     * @var string $name
	 * @var string $login
	 * @var string $pass
	 * @var string $status
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{operators}}';
	}

	public function rules()
	{
		return array(
			array('name, login, pass, status', 'required'),
			array('login, pass', 'length', 'max'=>128),
            array('name', 'max'=>10),
            array('name','safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
            'name'=>'ФИО',
			'login' => 'Логин',
			'pass' => 'Пароль',
			'status' => 'Статус',
		);
	}

	/**
	 * Checks if the given password is correct.
	 * @param string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password,$this->pass);
	}

	/**
	 * Generates the password hash.
	 * @param string password
	 * @return string hash
	 */
	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}
}
