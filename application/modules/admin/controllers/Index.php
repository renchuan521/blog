<?php


class IndexController extends Yaf_Controller_Abstract
{
    public function testAction()
    {
        echo 111;
        return false;
    }

    public function indexAction() {
        return TRUE;
    }


}