<?php

class UserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate()
	{
		$operator=Operator::model()->find('LOWER(login)=?',array(strtolower($this->username)));
		if($operator===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$operator->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->_id=$operator->id;
			$this->username=$operator->name;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}
}