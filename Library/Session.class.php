<?php
// 这是一个会话管理器
class Session{

  private static $_pool = array();//会话池
  private static $_default = 'default';

  private $id;
  protected $row;

  public static function set($id){
    self::$_default=$id;
  }
  public static function catch($id=''){
    if($id==''){
      $id=self::$_default;
    }
    return isset(self::$_pool[$id])?self::$_pool[$id]:null;
  }
  public static function fetch($id){
    return isset(self::$_pool[$id])?self::$_pool[$id]->row:null;
  }
  function __construct($id){
    $this->id=$id;
    self::$_pool[$id]=$this;
  }
  public function __get($name){
    return isset($this->row[$name])?$this->row[$name]:"";
  }
  public function __set($name,$value){
    $this->row[$name]=$value;
  }
}
