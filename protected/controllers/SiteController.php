<?php

class SiteController extends CController
{
	public function filters()
    {
        return array(
            'accessControl',
        );
    }

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to access 'login' and 'view' actions.
				'actions'=>array('login','error'),
				'users'=>array('?'),
			),
			array('allow', // allow authenticated users to access all actions
				'actions'=>array('index','logout','error'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}
	
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		// collect user input data
		if(isset($_POST['LoginSubmit']))
		{
		
			$identity = new UserIdentity($_POST['login'],$_POST['pass']);
			if($identity->authenticate()){
                Yii::app()->user->login($identity,0);
                $LoginError=false;
                $this->redirect(Yii::app()->user->returnUrl);
            }else{
                $LoginError=true;
			}
		}
		// display the login form
		$this->render('login',array('LoginError'=>$LoginError));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
