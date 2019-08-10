<?php
/**
 * @name
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author root
 */

class InterviewModel extends Model{
    
    protected $tableName = 'interview';

    public function __construct(){
        parent::__construct();
    }

    public function register( $username , $password){
        $res = $this->find(['username'=>$username]);
        print_r($res);die;
        return $res;
    }
    
    


}
