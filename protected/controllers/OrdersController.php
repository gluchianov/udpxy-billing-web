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
				'actions'=>array('index','view','add'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionAdd(){
        if (!isset($_GET['client'])) $this->redirect(array('/clients'));
        $client=Clients::model()->findByPk((int)$_GET['client']);

        //Добавление подписки
        if(isset($_POST['enddate'])&&($_POST['enddate']!='')){
            $neworder=new Orders();
            $neworder->id_tvpack=$_POST['tariffid'];
            $neworder->id_user=$_POST['clientid'];
			$neworder->id_allowed=0;
            $neworder->start_operator=Yii::app()->user->id;
            $neworder->end_operator=0;
            $neworder->status=1;
            $neworder->start_date=date("Y-m-d H:i:s",strtotime($_POST['startdate']));
            $neworder->end_date=date("Y-m-d H:i:s",strtotime($_POST['enddate'])+86399);

            if($neworder->save())
                $this->redirect(array('view','client'=>(int)$_POST['clientid']));

        }

        $tariffs=CHtml::listData(Tvpack::model()->findAll(),'id','name');


        $this->render('neworder',array('client'=>$client,'tariffs'=>$tariffs));
    }

    public function actionIndex(){
        $this->redirect(array("/clients"));
    }

	public function actionView()
	{
        //Закрытие оконченных подписок
        $this->CheckOrders();
        if (!isset($_GET['client'])) $this->redirect(array('/clients'));

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
        $criteria->order="id DESC";
        $archive_orders=Orders::model()->findAll($criteria);
        $archive_orders_arr=array();
        foreach ($archive_orders as $arch_order){
            $tmp=Tvpack::model()->findByPk($arch_order->id_tvpack);
            if ($tmp!=NULL) $tmp=$tmp->name;
            else $tmp='неизвестный тариф';

            if ($arch_order->end_operator==0) $end_operator='Система';
            else $end_operator=Operator::model()->findByPk($arch_order->end_operator)->name;

            $archive_orders_arr[]=array(
              'tariff'=>$tmp,
              'start_operator'=>Operator::model()->findByPk($arch_order->start_operator)->name,
              'end_operator'=>$end_operator,
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
