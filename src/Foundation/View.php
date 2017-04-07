<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午10:51
 */

namespace Yee\Foundation;
use \Yee\Contracts\Config;

class View
{
    private $VARIABLES;
    private $DIR;
    function __construct($APP)
    {
        if( $APP instanceof Config){
            $this->set($APP->ViewDir);
        }
    }

    function __get($name)
    {
        return isset($this->VARIABLES[$name])?:NULL;
    }
    function __set($name, $value)
    {
        $this->VARIABLES[$name] = $value;
    }
    function __call($name, $arguments)
    {
        echo $this->$name;
    }
    function __out(){
        return $this->VARIABLES;
    }
    function set($path){
        if(!is_dir($path)){
            return false;
        }
        $this->DIR = realpath($path).'/';
    }
    function render($name){
        $file = $this->DIR.$name.'.php';
        if( !file_exists($file)){
            throw new \Exception(sprintf("Template Not Found:%s\nPath:%s\n",$name,$file));
        }
        $file = realpath($file);
        if(substr($file,0,strlen($this->DIR)) != $this->DIR){
            throw new \Exception("Error Name:".$name);
        }
        $vars = $this->VARIABLES;
        $self = $this;
        (function() use ($vars,$file,$self ){
            extract($vars);
            include $file;
        })();
    }
    function toArray(){
        return $this->VARIABLES;
    }
    function toJson(){
//        \Yee\Foundation\Config::get()->Request()
        return json_encode($this->VARIABLES);
    }
}