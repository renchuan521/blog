<?php

if( !defined('YAF') )
    exit(-1);

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 *
 * 注意:方法在Bootstrap类中的定义出现顺序, 决定了它们的被调用顺序.
 */
class Bootstrap extends Yaf_Bootstrap_Abstract{

        public function _initSession (Yaf_Dispatcher $dispatcher)
        {
            Yaf_Session::getInstance()->start();

            header('content-type:text/html;charset=utf-8');
        }

	public function _initConfig() {
		$config = Yaf_Application::app()->getConfig();
		Yaf_Registry::set("config", $config);
	}

        public function _initLogger(Yaf_Dispatcher $dispatcher){
            \Common\Logger\Helper::$_logpath = APP_PATH . '/public/log';
        }

        public function _initDefaultName(Yaf_Dispatcher $dispatcher) {
		$dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
	}

        public function _initDb(Yaf_Dispatcher $dispatcher){
            \Db\Factory::create('mysql');
        }

        public function _initRoute(Yaf_Dispatcher $dispatcher) {
                $router = Yaf_Dispatcher::getInstance()->getRouter();
		//创建一个路由协议实例
                $route = new Yaf_Route_Rewrite(
                    'exp/:ident',
                    array(
                        'controller' => 'index',
                        'action' => 'index'
                    )
                );
                //使用路由器装载路由协议
                $router->addRoute('exp', $route);
	}

        public function _initUtil(Yaf_Dispatcher $dispatcher){
            Yaf_Loader::import('Common/Util.php');
        }
}