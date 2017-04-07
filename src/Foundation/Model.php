<?php

namespace Yee\Foundation;
class Model
{

    static $_CONNECTION;
    public function __construct($tableName = null)
    {
        if(!self::$_CONNECTION){
            $this->init();
        }
    }
    public function __call($func, $args) {
        return call_user_func_array(array(&self::$_CONNECTION, $func), $args);
    }
    private function init(){
        $mysql= Config::get()->MYSQL;
        self::$_CONNECTION = new DB(
            sprintf("mysql:host=%s;dbname=%s",$mysql['host'], $mysql['data']),
            $mysql['user'],
            $mysql['pass']);

    }
    function TableName(){
        return __CLASS__;
    }
    public function select($where)
    {
        $tableName = $this->TableName();
        $sql = "SELECT * FROM `$tableName` WHERE ";
        if (is_string($where)) {
            $sql += $where;
        } else if (is_array($where)) {
            foreach ($where as $key => $value) {
                $sql += " `$key`='$value' AND";
            }
            $sql += " 1=1";
        } else {
            return false;
        }
        return $this->query($sql)->fetch();
    }
}
