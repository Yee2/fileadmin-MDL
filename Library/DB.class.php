<?php
class DB{
  protected $PDO,$numExecutes,$numStatements;
  public function __call($func, $args) {
     return call_user_func_array(array(&$this->PDO, $func), $args);
  }
  public function query() {
    $args=func_get_args();
    $this->numExecutes++;
    $this->numStatements++;
    if(isset($args[1]) && is_array($args[1])){
      $n = 0;
      while (($offset=strpos($args[0],'?'))!=false) {
        if(isset($args[1][$n])){
          $args[0]=substr_replace($args[0],$this->format($args[1][$n]),$offset,1);
          $n++;
        }else{
          break;
        }
      }
      unset($args[1]);
      $args=array_merge($args);
    }
    // return $args[0];
    return call_user_func_array(array(&$this->PDO, 'query'), $args);

  }
  protected function format($array){
    if(is_string($array))
      return "'".str_replace("'","\\'",$array)."'";
    $str='';
    if(key($array)===0){
      foreach ($array as $key => $value) {
        $value=str_replace("'","\\'",$value);
        $str.="'$value',";
      }
    }else{
      foreach ($array as $key => $value) {
        $value=str_replace("'","\\'",$value);
        $str.="`$key`='$value',";
      }
    }
    return substr($str,0,-1);
  }
  public function __construct($dsn,$username=null,$password=null ,$driver_options=array()){
    $this->PDO=new \PDO($dsn,$username,$password,$driver_options);
    $this->PDO->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
  }
}
