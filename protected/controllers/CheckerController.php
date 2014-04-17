<?php

class CheckerController extends CController{

    // Returned values
    const UDPXY_RESPONSE_ACCEPT=1;
    const UDPXY_RESPONSE_DENY=0;

    public function actionIndex(){

        if ((!isset($_GET['claddr']))||($_GET['claddr']=='')||
            (!isset($_GET['maddr']))||($_GET['maddr']=='')||
            (!isset($_GET['mport']))||($_GET['mport']=='')||
            ($_GET['cmd']!='check'))
                echo self::UDPXY_RESPONSE_DENY;
        else {
            //Check orders for topicality
            Orders::model()->CheckOrders();

            //Select all active orders for current client
            $criteria=new CDbCriteria();
            $criteria->select=array('id_tvpack');
            $criteria->with=array('user','allowed');
            $criteria->addCondition('start_date<=NOW() AND end_date>=NOW()');
            $criteria->addCondition('status=1');

            $criteria2= new CDbCriteria();
            $criteria2->addCondition('user.ip=:claddr');
            $criteria2->addCondition('INET_ATON(allowed.ip_start)<=INET_ATON(:claddr) AND INET_ATON(allowed.ip_end)>=INET_ATON(:claddr)','OR');

            $criteria->mergeWith($criteria2);
            $criteria->params=array(':claddr'=>$_GET['claddr']);
            $active_orders=Orders::model()->findAll($criteria);

            //Check exist current channel in active orders
            $channels_count=0;
            if (count($active_orders)>0){
                $criteria = new CDbCriteria();
                $criteria->with=array('tvpackids');
                $criteria->compare('m_ip',$_GET['maddr']);
                $criteria->compare('m_port',$_GET['mport']);

                $criteria2 = new CDbCriteria();
                foreach ($active_orders as $order)
                    $criteria2->compare('tvpackids.id_tvpack',$order->id_tvpack,false,"OR");
                $criteria->mergeWith($criteria2,'AND');
                $channels_count=Channels::model()->count($criteria);
            }

            if ($channels_count>0) echo self::UDPXY_RESPONSE_ACCEPT;
            else echo self::UDPXY_RESPONSE_DENY;
        }
    }
} 