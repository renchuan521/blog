<?php
/**
 * @name IndexController
 * @author root
 * @desc 默认控制器
 * @see http://www.php.net/manual/en/class.yaf-controller-abstract.php
 */
class UserController extends Controller {
    /** 
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/sample/index/index/index/name/root 的时候, 你就会发现不同
     */
    public function IndexAction() {

        return FALSE;
    }
    
    public function RegisterAction() {
        if($this->getRequest()->isPost()) {
            $username = $this->getRequest()->getPost('username',false);
            $password = $this->getRequest()->getPost('password',false);
            $class_id = $this->getRequest()->getPost('class_id',false);
            if(empty($username) || empty($password || empty($class_id))){
                echo $this->json(['errno'=>100001,'errmsg'=>'empty message!']);
                return FALSE;
            }

            $user = new UserModel();
            $res = $user->register($username, $password);
            echo $this->json($res);
            return FALSE;
        }
        $classes = new ClassesModel();
        $classes = $classes->getClasses();
        $this->assign(['classes'=>$classes]);
        return TRUE;

    }
    
    public function LoginAction() {
       
        return FALSE;
    }

    public function SaveAction(){
        return true;
    }
}
