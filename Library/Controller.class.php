<?php
 /*
 参考规范 https://github.com/darcyliu/google-styleguide/blob/master/JSONStyleGuide.md
 成功时候：
 {
 "apiVersion":"1.0",
 "data":{}
}
发生错误的时候：
{
 "apiVersion":"1.0",
 "error":{
 code:404,
 message:"",
 errors:[]
}
}
注error与data不能同时存在
*/
class Controller extends Session{
  protected $id = 'default';
  function __construct()
  {
    parent::__construct($this->id);
    $this->apiVersion = "1.0";
  }
  public function errorCode(int $code){
    $this->row['error']['code']=$code;
  }
  public function errorMessage(string $msg){
    $this->row['error']['message']=$msg;
  }
  public function error($code,$message='',$errors=array()){
    if(is_array($code)){
      $this->row['error']=$code;
      return ;
    }
    $this->row['error']=array(
      'code'=>$code,
      'message'=>$message,
      'errors'=>$errors
    );
  }

  public function data($data){
    $this->row["data"]=$data;
  }

  function add($key,$value=null){
    if($value===null && is_array($key)){
      $this->row=array_merge($this->row,$key);
    }
    if(is_string($key)){
      $this->row[$key]=$value;
    }
    return ;
  }

  function show(){
    if(isset($this->row['error']) && isset($this->row['data'])){
      unset($this->row['data']);
    }
    $this->row['session']=$this->id;
    ob_clean();
    exit(json_encode($this->row));
  }
}
