<?php

class Controller extends Yaf_Controller_Abstract
{


    public function init(){

    }
    
    public function json($data=[]){
        return json_encode($data);
    }
    
    public function assign($params=[]){
        if(is_array($params) && !empty($params)){
            $this->getView()->assign($params);
        }
    }
}