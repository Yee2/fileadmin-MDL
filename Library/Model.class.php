<?php
class Model extends DB{
  protected $tableName;
  function __construct($tableName=null){
    $mysql=C('mysql');
    $this->tableName=C('mysql')['front'].$tableName;
    return parent::__construct(
    "mysql:host=".$mysql['host'].";dbname=".$mysql['data'],
    $mysql['user'],$mysql['pass']);
  }
  public function select($where){
    $tableName=$this->$tableName;
    $sql="SELECT * FROM `$tableName` WHERE ";
    if(is_string($where)){
      $sql+=$where;
    }else if(is_array($where)){
      foreach ($where as $key => $value) {
        $sql+=" ``$key`='$value' AND";
      }
      $sql += " 1=1";
    }else{
      return false;
    }
    return $this->query($sql)->fetch();
  }
}
