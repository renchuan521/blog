<?php

namespace Db;

if (!defined('YAF'))
    exit(-1);

/**
 * mysql操作类
 *
 * @author zxcvdavid@gmail.com
 *
 */
class Mysql implements DbInterface {

    private static $_instances;
    private $_dbh;
    private $_sth;
    private $_sql;

    private function __construct($dbhost, $username, $password, $dbname, $dbcharset) {
        try {
            $this->_dbh = new \PDO('mysql:dbname=' . $dbname . ';host=' . $dbhost, $username, $password);
            $this->_dbh->query('SET NAMES '.$dbcharset);
        } catch (PDOException $e) {
            echo '<pre>';
            echo '<b>Connection failed:</b> ' . $e->getMessage();
            die();
        }
    }

    static public function getInstance($db_config = '') {

        $_db_host = $db_config->host;
        $_db_name = $db_config->dbname;
        $_db_charset = $db_config->charset;
        $_db_user = $db_config->user;
        $_db_pwd = $db_config->password;

        $idx = md5($_db_host . $_db_name);
        if (!isset(self::$_instances[$idx])) {
            self::$_instances[$idx] = new Mysql($_db_host, $_db_user, $_db_pwd, $_db_name, $_db_charset);
        }
        return self::$_instances[$idx];
    }

    function halt($msg = '', $sql = '') {

        $error_info = $this->_sth->errorInfo();
        $s = '<pre>';
        $s .= '<b>Error:</b>' . $error_info[2] . '<br />';
        $s .= '<b>Errno:</b>' . $error_info[1] . '<br />';
        $s .= '<b>Sql:</b>' . $this->_sql;
        exit($s);
    }

    function execute($sql, $values = array()) {
        $this->_sql = $sql;
        $this->_sth = $this->_dbh->prepare($sql);
        $bool = $this->_sth->execute($values);
        if ('00000' !== $this->_sth->errorCode()) {
            $this->halt();
        }
        return $bool;
    }

    
    public function select($sql, $values = array(), $fetch_style = \PDO::FETCH_ASSOC){
        $this->execute($sql, $values);
        return $this->_sth->fetchAll($fetch_style);
    }

    public function save($sql = '',$values=[]){
        return $this->execute($sql, $values);  
    }

    public function delete($sql = '',$values = []){
        return $this->execute($sql, $values);   
    }

    public function find($sql, $values = array(), $column_number = 0){
        $this->execute($sql, $values);
        return $this->_sth->fetchColumn($column_number);
    }
    
    public function getLastSql(){
        return $this->_sql;
    }

}