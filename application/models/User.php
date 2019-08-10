<?php
/**
 * @name
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author root
 */

class UserModel extends Model{
    
    protected $tableName = 'user';
    private $token;

    public function __construct(){
        parent::__construct();
    }
    
    public function encrypt($username,$password){
        $this->token = time().rand(1111,9999) ;
        return md5($username. md5($password).$this->token);
    }

    public function register( $username , $password){
        $res = $this->find(['username'=>$username]);
        if($res) return ['code'=>10001,'msg'=>'Users already exist!'];
        $res = $this->save(['username'=>$username,'password'=>$this->encrypt($username,$password),'token'=>$this->token,'add_time'=>time()]);
        if($res){
            return ['code'=>200,'msg'=>'Success！'];
        }else{
            return ['code'=>10002,'msg'=>'Server timeout！Please try again later！！！'];
        }
    }
    
    


}
