<?php

class TariffsController extends CController{

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
                'actions'=>array('index','detail'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex(){
        if ((isset($_POST['newName'])&&($_POST['newName'])!='')&&
        (isset($_POST['newDescr'])&&($_POST['newDescr'])!='')){
            $tariff= new Tvpack();
            $tariff->name=$_POST['newName'];
            $tariff->descr=$_POST['newDescr'];
            if ($tariff->save())
                $this->redirect(array("index"));
        }


        $tariffs = Tvpack::model()->findAll();
        $this->render('index',array('tariffs'=>$tariffs));
    }
    public function actionDetail(){
        $tariff=Tvpack::model()->findByPk((int)$_GET['id']);

        //----------------Управление тарифом----------------
        if (isset($_POST['newName'])&&($_POST['newName'])!=''){
            $tariff->name=$_POST['newName'];
            if($tariff->save())
                $this->redirect(array('detail','id'=>$tariff->id));
        }
        if (isset($_POST['newDescr'])&&($_POST['newDescr'])!=''){
            $tariff->descr=$_POST['newDescr'];
            if($tariff->save())
                $this->redirect(array('detail','id'=>$tariff->id));
        }
        if (isset($_POST['deleteTid'])&&($_POST['deleteTid'])!=''){
            if ((int)$_POST['deleteTid']==$tariff->id)
                if ($tariff->delete())
                    $this->redirect(array("index"));
        }
        //----------------Управление каналами в тарифе----------------


        $this->render('detail',array('tariff'=>$tariff));
    }

} 