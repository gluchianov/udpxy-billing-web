<?php
class MyController extends CController{

    private function GetRealIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) $ip=$_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        else $ip=$_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    public function actionIndex(){
        
        $criteria=new CDbCriteria();
        $criteria->select=array('start_date','end_date');
        $criteria->addCondition('INET_ATON(allowed.ip_start)<=:claddr');
        $criteria->addCondition('INET_ATON(allowed.ip_end)>=:claddr');
        $criteria->params=array(':claddr'=>ip2long($this->GetRealIp()));
        $criteria->with=array('allowed'=>array('allowed.descr'),'tvpack'=>array('tvpack.name'));
        $criteria->together=true;
        $allowed_list=Orders::model()->findAll($criteria);

        $criteria=new CDbCriteria();


        $criteria=new CDbCriteria();
        $criteria->addCondition('ip=:claddr');
        $criteria->params=array(':claddr'=>$this->GetRealIp());
        $user=Clients::model()->find($criteria);

        $this->render('index',array('allowed_list'=>$allowed_list,'user'=>$user,'ip'=>$this->GetRealIp()));
    }
} 