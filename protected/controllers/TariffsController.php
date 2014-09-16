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

        //Add free channels to tvpack
        if (isset($_POST['chaddids'])&&(count($_POST['chaddids'])>0)){
            foreach ($_POST['chaddids'] as $chid){
                $tvaccos=new TvpackList();
                $tvaccos->id_channel=(int)$chid;
                $tvaccos->id_tvpack=(int)$_GET['id'];
                $tvaccos->save();
            }
        }

        //Удаление канала из тарифа
        if (isset($_POST['deleteChId'])&&($_POST['deleteChId'])!=''){
            TvpackList::model()->deleteAllByAttributes(array('id_channel'=>(int)$_POST['deleteChId']));
        }

        $tariff=Tvpack::model()->with(array('channels'))->findByPk((int)$_GET['id']);
        if ($tariff==NULL) $this->redirect(array('index'));

        $criteria= new CDbCriteria();
        $criteria->with=array('tvpackids');
        //Bug! Not display free channels: $criteria->condition='tvpackids.id_tvpack<>:idtvpack';
        $criteria->params=array(':idtvpack'=>(int)$_GET['id']);
        $freeChannels=Channels::model()->findAll($criteria);
        $chlist=CHtml::listData($freeChannels,'id','ch_name');

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
                if ($tariff->delete()){
                    TvpackList::model()->deleteAllByAttributes(array('id_tvpack'=>$tariff->id));
                    $this->redirect(array("index"));
                }

        }

        $this->render('detail',array('tariff'=>$tariff,'chlist'=>$chlist));
    }

} 