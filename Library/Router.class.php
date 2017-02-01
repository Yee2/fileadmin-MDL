<?php
/**
 *
 */
class Router
{

  function __construct($defaultController="default",$defaultMethod="index")
  {
    // xxoo();
    $queryArray=explode("/",urldecode(explode("#",substr($_SERVER['REQUEST_URI'],strlen($_SERVER['SCRIPT_NAME'])+1))[0]));
    $c=array_shift($queryArray)?:$defaultController;
    $method=array_shift($queryArray)?:$defaultMethod;
    $ControllerName=$c."Controller";
    if(strstr($ControllerName,"/") || !class_exists($ControllerName)){
      throw new Exception("非法请求".$ControllerName, 1);
    }
    $Controller=new $ControllerName();
    if(method_exists($Controller,$method)){
      $res=call_user_func_array(array(&$Controller, $method), $queryArray);
      // $Controller->show();
      return $res;
    }else{
      throw new Exception("非法请求:".$method);

    }
  }
}
