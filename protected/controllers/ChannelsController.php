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

        if (isset($_FILES['playlistfile'])){
            $channels=$this->ParseM3UPlaylist($_FILES['playlistfile']['tmp_name']);
            foreach ($channels as $channel){
                $newchanel=new Channels();
                $newchanel->ch_name=$channel['name'];
                $newchanel->m_ip=$channel['maddr'];
                $newchanel->m_port=$channel['mport'];
                $newchanel->params=json_encode($channel['params']);
                $newchanel->save();
            }
        }

        $chanells=Channels::model()->findAll();

        $this->render('index',array('chanells'=>$chanells));

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

                    if (preg_match("/(deinterlace=)(\d?)/",$extinf,$inf)) $ch_arr['params']['deinterlace']=$inf[2];
                    if (preg_match("/(tvg-shift=)(-?\d?)/",$extinf,$inf)) $ch_arr['params']['tvg-shift']=$inf[2];

                    preg_match("/^udp:\/\/@(.*):(\d*)$/m",$urlstr,$ch_url);

                    $ch_arr['name']=end(explode(',',$extinf));
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