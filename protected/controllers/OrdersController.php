<?php

class OrdersController extends CController
{
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionIndex(){
        $this->redirect(array("/clients"));
    }

	public function actionView()
	{
        //Закрытие оконченных подписок
        $this->CheckOrders();

        //-------------Закрытие подписки ----------------------------------
        if (isset($_POST['deleteOId'])&&($_POST['deleteOId'])!=''){
                if ($this->StopOrder((int)$_POST['deleteOId'],Yii::app()->user->id))
                    $this->redirect(array("orders/view","client" => (int)$_GET['client']));
        }

        //-----------Извлечение активных подписок--------------------------
        $orders=array();
        $client=Clients::model()->findByPk((int)$_GET['client']);
        $tariffs=Tvpack::model()->findAll();
        foreach ($tariffs as $t){

            $criteria = new CDbCriteria;
            $criteria->compare('id_tvpack',$t->id);
            $criteria->compare('id_user',$client->id);
            $criteria->addCondition('end_date>NOW() AND (status=1)');

            $orders[$t->name]=Orders::model()->findAll($criteria);
        }

        //------------Извлечение истории-----------------------------------
        $criteria = new CDbCriteria;
        $criteria->compare('id_user',$client->id);
        $criteria->compare('status',0);
        $criteria->limit=10;
        $archive_orders=Orders::model()->findAll($criteria);
        $archive_orders_arr=array();
        foreach ($archive_orders as $arch_order){
            $tmp=Tvpack::model()->findByPk($arch_order->id_tvpack);
            if ($tmp!=NULL) $tmp=$tmp->name;
            else $tmp='неизвестный тариф';
            $archive_orders_arr[]=array(
              'tariff'=>$tmp,
              'start_operator'=>Operator::model()->findByPk($arch_order->start_operator)->name,
              'end_operator'=>Operator::model()->findByPk($arch_order->end_operator)->name,
              'ord_data'=>$arch_order,
            );
        }

        $this->render('view',array('cl'=>$client,'tariffs'=>$orders,'history_data'=>$archive_orders_arr));
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
