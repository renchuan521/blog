<?php

namespace Db;

if (!defined('YAF'))
    exit(-1);



/*
 * Db接口定义
 *
 * @author zxcvdavid@gmail.com
 *
 */

interface DbInterface {

    static public function getInstance(); //要求所有数据连接皆为单例

}