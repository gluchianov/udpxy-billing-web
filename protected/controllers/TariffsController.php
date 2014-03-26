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
        if ($tariff==NULL) $this->redirect(array('index'));

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
        //----------------Управление каналами в тарифе----------------
        if ((isset($_POST['newChName'])&&($_POST['newChName']))&&
            (isset($_POST['newChIP'])&&($_POST['newChIP']))&&
            (isset($_POST['newChPort'])&&($_POST['newChPort']))){

                $newchanel=new TvpackList();
                $newchanel->id_tvpack=$tariff->id;
                $newchanel->ch_name=$_POST['newChName'];
                $newchanel->m_ip=$_POST['newChIP'];
                $newchanel->m_port=$_POST['newChPort'];
                if($newchanel->save())
                    $this->redirect(array('detail','id'=>$tariff->id));
        }

        if (isset($_POST['deleteChId'])&&($_POST['deleteChId'])!=''){
                $ch=TvpackList::model()->findByPk((int)$_POST['deleteChId']);
                if ($ch->delete())
                    $this->redirect(array('detail','id'=>$tariff->id));
        }

        $criteria= new CDbCriteria();
        $criteria->compare('id_tvpack',$tariff->id);
        $chanells=TvpackList::model()->findAll($criteria);


        $this->render('detail',array('tariff'=>$tariff,'chanells'=>$chanells));
    }

} 