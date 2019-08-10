<?php


class IndexController extends BaseController {

    public function init() {
       

    }

    public function indexAction() {
        
        
        $bar = $this->foo();
        var_export($bar);
        return TRUE;
    }
    
    public function foo(){
        $var = "hello,world!";
        return $var;
    }

    public function contactAction() {
        return TRUE;
    }

    public function featuresAction() {
        return TRUE;
    }

    public function pricingAction() {
        return TRUE;
    }
    public function tourAction() {
        return TRUE;
    }


}
