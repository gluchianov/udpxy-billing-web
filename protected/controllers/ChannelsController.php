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
            (isset($_POST['newChType'])&&($_POST['newChType']))&&
            (isset($_POST['newChAddress'])&&($_POST['newChAddress']))){

            if($this->AddChannel($_POST['newChName'],$_POST['newChType'],$_POST['newChAddress'],json_encode(array())));
                $this->redirect(array('index'));
        }

        if (isset($_POST['clearchannels'])&&($_POST['clearchannels']==1)){
            Channels::model()->deleteAll();
			TvpackList::model()->deleteAll();
            $this->redirect(array('index'));
        }

        if (isset($_POST['deleteChId'])&&($_POST['deleteChId'])!=''){
            $ch=Channels::model()->findByPk((int)$_POST['deleteChId']);
            if ($ch->delete())
                TvpackList::model()->deleteAllByAttributes(array('id_channel'=>(int)$_POST['deleteChId']));
                $this->redirect(array('index'));
        }

        $chanells=Channels::model()->findAll();

        $this->render('index',array('chanells'=>$chanells));

    }

    private function AddChannel($ch_name,$stream_type,$stream_address,$params){
        $ch_name=str_replace(array("\r\n", "\r", "\n"),'', trim($ch_name));
        $channels=Channels::model()->findAllByAttributes(array('ch_name'=>$ch_name));
        if (count($channels)!=0){
            foreach ($channels as $newchanel){
                $newchanel->ch_name=$ch_name;
                $newchanel->stream_type=trim($stream_type);
                $newchanel->stream_address=str_replace(array("\r\n", "\r", "\n"),'', trim($stream_address));
                $newchanel->params=$params;
                $newchanel->save();
            }
            return NULL;
        }else{
            $newchanel = new Channels();
            $newchanel->ch_name=$ch_name;
			$newchanel->stream_type=trim($stream_type);
			$newchanel->stream_address=str_replace(array("\r\n", "\r", "\n"),'', trim($stream_address));
            $newchanel->params=$params;
            if($newchanel->save())
                return $newchanel->id;
            else return NULL;
        }
    }

} 