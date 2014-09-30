<?php
class SevStarPlaylist {

    public function Parse($filepath){
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
                $urlstr=stristr($buffer[$pos+1],"http://ott-stream.sevstar.net");
                if (($extinf!=null)&&($urlstr!=null)){
                    $ch_arr=array();

                    preg_match("/^http:\/\/ott-stream.sevstar.net\/(\d*)\/mpegts/m",$urlstr,$ch_url);

                    $ch_arr['name']=end(explode(',',$extinf));
                    $ch_arr['type']='HTTP';
                    $ch_arr['address']='ott-stream.sevstar.net:80/'.$ch_url[1].'/mpegts';
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