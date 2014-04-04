<?php

class LiteTextDb extends CComponent{

    private $_dbfile = '';
    private $_params = array();
    private $_newparams = array();

    function __construct() {
        $this->_dbfile=Yii::app()->params['liteDbFile'];
    }

    private function load_db(){
        $this->_params=json_decode(file_get_contents($this->_dbfile),true);
        if ($this->_params==NULL) $this->_params=array();
    }
    public function write_db(){
        $this->load_db();
        $result=array_merge($this->_params,$this->_newparams);
        file_put_contents($this->_dbfile,json_encode($result));
    }

    public function add_param($param_name, $param_value){
        $this->_newparams[$param_name]=$param_value;
    }
    public function add_params($params_arr){
        foreach ($params_arr as $pkey=>$pvalue){
            $this->add_param($pkey,$pvalue);
        }
    }
    public function get_values(){
        $this->load_db();
        return $this->_params;
    }
    public function get_value($pname){
        $this->load_db();
		if (!isset($this->_params[$pname])) return NULL;
		else $this->_params[$pname];
    }




} 