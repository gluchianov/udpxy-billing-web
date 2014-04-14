<?php

class ChannelsController extends CController{

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
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex(){

        //----------------Управление каналами в тарифе----------------
        if ((isset($_POST['newChName'])&&($_POST['newChName']))&&
            (isset($_POST['newChIP'])&&($_POST['newChIP']))&&
            (isset($_POST['newChPort'])&&($_POST['newChPort']))){

            $newchanel=new Channels();
            $newchanel->ch_name=$_POST['newChName'];
            $newchanel->m_ip=$_POST['newChIP'];
            $newchanel->m_port=$_POST['newChPort'];
            if($newchanel->save())
                $this->redirect(array('index'));
        }

        if (isset($_POST['deleteChId'])&&($_POST['deleteChId'])!=''){
            $ch=Channels::model()->findByPk((int)$_POST['deleteChId']);
            if ($ch->delete())
                $this->redirect(array('index'));
        }

        $chanells=Channels::model()->findAll();

        $this->render('index',array('chanells'=>$chanells));

    }

} 