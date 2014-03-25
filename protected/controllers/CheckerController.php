<?php

class CheckerController extends CController{

    public function actionIndex(){
        if ((!isset($_GET['claddr']))||($_GET['claddr']=='')||(!isset($_GET['maddr']))||($_GET['maddr']=='')||(!isset($_GET['mport']))||($_GET['mport']=='')||($_GET['cmd']!='check'))
            echo 0;
        else{
            $criteria=new CDbCriteria();
            $criteria->addCondition('ip=:claddr');
            $criteria->params=array(':claddr'=>$_GET['claddr']);
            $user=Clients::model()->find($criteria);
            if ($user==NULL)
                echo 0;
            else{
                $tvpack=TvpackList::model()->findAllByAttributes(array('m_ip'=>$_GET['maddr'],'m_port'=>$_GET['mport']));
                $pack_count=0;
                foreach ($tvpack as $pack){
                    $criteria=new CDbCriteria();
                    //$criteria->select="COUNT(id) as order_count";
                    $criteria->compare('id_tvpack',$pack->id_tvpack);
                    $criteria->compare('id_user',$user->id);
                    $criteria->addCondition('start_date<=NOW() AND end_date>=NOW()');
                    $criteria->compare('status',1);
                    $orders=Orders::model()->findAll($criteria);
                    $pack_count+=count($orders);
                }
                if ($pack_count==0) echo 0;
                else echo 1;
            }
        }

    }
} 