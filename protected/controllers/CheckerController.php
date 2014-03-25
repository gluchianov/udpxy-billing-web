<?php

class CheckerController extends CController{

    public function actionIndex(){
        if ((!isset($_GET['claddr']))||($_GET['claddr']=='')||(!isset($_GET['maddr']))||($_GET['maddr']=='')||(!isset($_GET['mport']))||($_GET['mport']=='')||($_GET['cmd']!='check'))
            echo 0;
        else{

            $this->CheckOrders();
            $lastupdate=new LiteTextDb();
            $lastupdate->add_param('udpxy_lastact',time());
            $lastupdate->write_db();

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
    private function StopOrder($id,$end_operator_id=65000){
        $del_order=Orders::model()->findByPk($id);
        $del_order->status=0;
        $del_order->end_date=date("Y-m-d H:i:s");
        $del_order->end_operator=$end_operator_id;
        if ($del_order->save())
            return true;
        else return false;
    }

    private function CheckOrders(){
        $criteria = new CDbCriteria();
        $criteria->compare('status',1);
        $criteria->AddCondition('end_date<NOW()');
        $cl_order=Orders::model()->findAll($criteria);
        foreach ($cl_order as $cl)
            $this->StopOrder($cl->id);
    }
} 