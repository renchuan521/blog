<?php
/**
 * @name
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author root
 */

class ClassesModel extends Model{
    
    protected $tableName = 'classes';

    public function __construct(){
        parent::__construct();
    }

    public function getClasses(){
        $res = $this->select();
        return $res;
    }
    
    


}
