<?php
define("__ROOT__",str_replace("\\","/",__DIR__));
error_reporting(0);
// header('Content-type: application/vnd.api+json');
header('Access-Control-Allow-Origin: *');
function C($key=null,$value=null){
  static $settings=array();
  if(is_array($key) && $value===null){
    $settings=array_merge($settings,$key);
    return ;
  }else if(is_string($key) && $key!== null && $value===null){
    return isset($settings[$key])?$settings[$key]:null;
  }else if(is_string($key) && $key!== null && $value!==null){
    $setting[$key]=$value;
    return ;
  }else if($key===null && $value===null){
    return $settings;
  }else{
    return ;
  }
}
function __autoload($className) {
  if(substr($className, -5)==='Model' && $className!=="Model"){
    $path=__ROOT__."/Model/$className.php";
  }elseif(substr($className, -10)==='Controller'  && $className!=="Controller"){
    $path=__ROOT__."/Controller/$className.php";
  }else{
    $path=__ROOT__."/Library/$className.class.php";
  }
  if(file_exists($path)){
    require_once($path);
  }else{
    $msg="类文件没有找到:".$path;
    throw new Exception($msg);
    return ;
  }
  if(!class_exists($className)){
    $msg="类没有找到:".$className."\n文件:".$path;
    throw new Exception($msg);
    return ;
  }
  return ;
}
function getLine(array $e){
  $arr=file($e['file']);
  $line=$e['line']-1;
  return trim($arr[$line]);
}
register_shutdown_function(function(){
  $e = error_get_last();
  $Session = Session::catch();
  if(isset($e['type'])){
    switch ($e['type']) {
      case E_PARSE:
      $msg  ="PHP解析错误\n";
      $msg .='错误文件：'.$e['file']."\n(".$e['line'].":".getLine($e).")";
      $Session->error = array(
      'code'=>E_PARSE,
      'message'=>$msg,
      'errors'=>array()
      );
      break;

      case E_ERROR:
      $msg  ="PHP出现致命错误\n";
      $msg .='错误文件：'.$e['file']."\n(".$e['line'].":".getLine($e).")";
      $Session->error = array(
      'code'=>E_ERROR,
      'message'=>$msg,
      'errors'=>array()
      );
      break;

      case E_WARNING:
      $msg  ="PHP警告\n";
      $msg .='错误文件：'.$e['file']."\n(".$e['line'].":".getLine($e).")";
      $Session->waring = array(
      'code'=>E_WARNING,
      'message'=>$msg,
      'errors'=>array()
      );
      break;

      case E_NOTICE:
      $msg  ="PHP提醒\n";
      $msg .='错误文件：'.$e['file']."\n(".$e['line'].":".getLine($e).")";
      $Session->notice = array(
      'code'=>E_NOTICE,
      'message'=>$msg,
      'errors'=>array()
      );
      break;

      default:
      # code...
      break;
    }
  }
  $Session->show();
});
C(include(__ROOT__.'/setting.php'));
try{
  new Router();
}catch(Exception $e){
  new ExceptionController($e);
}
