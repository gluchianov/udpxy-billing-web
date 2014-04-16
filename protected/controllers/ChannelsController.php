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

            if($this->AddChannel($_POST['newChName'],$_POST['newChIP'],$_POST['newChPort'],json_encode(array())));
                $this->redirect(array('index'));
        }

        if (isset($_POST['clearchannels'])&&($_POST['clearchannels']==1)){
            if (Channels::model()->deleteAll())
                $this->redirect(array('index'));
        }

        if (isset($_POST['deleteChId'])&&($_POST['deleteChId'])!=''){
            $ch=Channels::model()->findByPk((int)$_POST['deleteChId']);
            if ($ch->delete())
                $this->redirect(array('index'));
        }

        if (isset($_FILES['playlistfile'])){
            $channels=$this->ParseM3UPlaylist($_FILES['playlistfile']['tmp_name']);
            foreach ($channels as $channel){
                if (isset($_POST['createTariffs'])&&($_POST['createTariffs']=='on')&&($channel['tariff']!='')&&($channel['tariff']!=NULL)){
                    $tvpack=Tvpack::model()->findAllByAttributes(array('name'=>$channel['tariff']));
                    if (count($tvpack)==0){
                        $tariff = new Tvpack();
                        $tariff->name=$channel['tariff'];
                        $tariff->descr=$channel['tariff'];
                        $tariff->save();
                    }
                    //TODO: Добавление канала в добавленный пакет;
                }
                $this->AddChannel($channel['name'],$channel['maddr'],$channel['mport'],json_encode($channel['params']));
            }
        }

        $chanells=Channels::model()->findAll();

        $this->render('index',array('chanells'=>$chanells));

    }

    private function AddChannel($ch_name,$m_ip,$m_port,$params){
        $ch_name=str_replace(array("\r\n", "\r", "\n"),'', trim($ch_name));
        $channels=Channels::model()->findAllByAttributes(array('ch_name'=>$ch_name));
        if (count($channels)!=0){
            foreach ($channels as $newchanel){
                $newchanel->ch_name=$ch_name;
                $newchanel->m_ip=str_replace(array("\r\n", "\r", "\n"),'', trim($m_ip));
                $newchanel->m_port=trim($m_port);
                $newchanel->params=$params;
                $newchanel->save();
            }
            return true;
        }else{
            $newchanel = new Channels();
            $newchanel->ch_name=$ch_name;
            $newchanel->m_ip=str_replace(array("\r\n", "\r", "\n"),'', trim($m_ip));
            $newchanel->m_port=trim($m_port);
            $newchanel->params=$params;
            if($newchanel->save())
                return true;
            else return false;
        }
    }

    private function ParseM3UPlaylist($filepath){
        $handle = @fopen($filepath, "r");
        if ($handle) {
            $buffer = array();
            while (($line = fgets($handle)) !== false) {
                if(($line != "\n") && ($line != "\r") && ($line != "\r\n") && ($line != "\n\r"))
                    $buffer[] = $line;
            }
            $pos=0;
            $channels=array();
            while ($pos<count($buffer)){
                $extinf=stristr($buffer[$pos],"#EXTINF:");
                $urlstr=stristr($buffer[$pos+1],"udp://@");
                if (($extinf!=null)&&($urlstr!=null)){
                    $ch_arr=array();

                    if (preg_match("/(group-title=\")(.*?)\"/",$extinf,$tariff)) $cur_tariff=$tariff[2];

                    $ch_arr['params']=array();
                    if (preg_match("/(deinterlace=)(\d?)/",$extinf,$inf)) $ch_arr['params']['deinterlace']=$inf[2];
                    if (preg_match("/(tvg-shift=)(-?\d?)/",$extinf,$inf)) $ch_arr['params']['tvg-shift']=$inf[2];

                    preg_match("/^udp:\/\/@(.*):(\d*)$/m",$urlstr,$ch_url);

                    $ch_arr['name']=end(explode(',',$extinf));
                    $ch_arr['tariff']=$cur_tariff;
                    $ch_arr['maddr']=$ch_url[1];
                    $ch_arr['mport']=$ch_url[2];
                    $pos++;
                    $channels[]=$ch_arr;
                }
                $pos++;
            }
            fclose($handle);
            return $channels;
        }
    }

} 