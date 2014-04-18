<?php
class MyController extends CController{

    public function actionIndex(){

        //Select all active orders and allowed for current client
        $active_orders=Orders::model()->GetActiveOrders(Yii::app()->request->getUserHostAddress(), Orders::GET_ONLYUSER);
        $active_allowed=Orders::model()->GetActiveOrders(Yii::app()->request->getUserHostAddress(),Orders::GET_ONLYALLOWED);
        //Get client info by address
        $userinfo=Clients::model()->GetClientByIP(Yii::app()->request->getUserHostAddress());
        $this->render('index',array('allowed_list'=>$active_allowed,'orders'=>$active_orders,'user'=>$userinfo));
    }

    public function actionGetPlaylist(){

        $active_packs=Orders::model()->GetActiveOrders(Yii::app()->request->getUserHostAddress(),Orders::GET_ALLINFO,'id_tvpack');

        $channelslist=array();
        foreach ($active_packs as $packid){
            $channels=Tvpack::model()->with(array('channels'))->findByPk($packid->id_tvpack)->channels;
            foreach ($channels as $channel){
                $channelslist[$channel->id]=$channel;
            }
        }

        ob_start();

echo "#EXTM3U cache=1000 deinterlace=7 url-tvg=\"".Yii::app()->params['tv_program_url']."\" tvg-shift=0 m3uautoload=1
";
        $pstr='';
    foreach ($channelslist as $channel){
        foreach (json_decode($channel->params) as $pkey=>$param)
            $pstr.=$pkey.'="'.$param.'" ';

echo '
#EXTINF:-1 '.$pstr.' tvg-name="'.str_replace(' ','_',$channel['ch_name']).'" tvg-logo="'.$channel['ch_name'].'" ,'.$channel['ch_name'].'
http://'.Yii::app()->params['udpxy_host'].':'.Yii::app()->params['udpxy_port'].'/udp/'.$channel['m_ip'].':'.$channel['m_port'];
        $pstr='';
    }

        header("Content-Disposition: attachment; filename=iptv_playlist.m3u");
        header("Contenr-type: application/octet-stream");
        header("Content-length: ".ob_get_length());
        ob_end_flush();



    }
} 