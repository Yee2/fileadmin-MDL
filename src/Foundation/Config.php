<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 上午11:54
 */

namespace Yee\Foundation;
use Yee\Contracts\Config as BaseConfig;
use Yee\Contracts\Router as BaseRouter;
use Yee\Contracts\Request as BaseRequest;
use Yee\Contracts\Log as BaseLog;

class Config implements BaseConfig
{
    protected static $_SELF;
    private $_CONFIG = [];
    protected $REQUEST,$ROUTER,$LOG;
    function setRouter(BaseRouter $router)
    {
        $this->ROUTER = $router;
    }
    function Router(): BaseRouter
    {
        return $this->ROUTER;
    }
    function AppName(): string
    {
        return $this->AppName;
    }
    public function setRequest(BaseRequest $request){
        $this->REQUEST = $request;
    }
    public function Request(): BaseRequest
    {
        return $this->REQUEST;
    }
    public function defaultController($className)
    {
        if(!class_exists($className)) {
            throw new \Exception("设置默认控制器发生错误");
        }
        $this->defaultController = $className;
        return $this;
    }
    public function setLog(BaseLog $log){
        $this->LOG = $log;
    }
    public function Log():BaseLog
    {
        return $this->LOG;
    }
    public static function get(){
        return self::$_SELF;
    }

    public function __construct(array $config = [])
    {
        $this->_CONFIG = array_merge($this->_CONFIG,$config);
        $this->setRouter(new Router($this));
        $this->setRequest(new Request($this));
        $this->setLog(new Log($this));
        self::$_SELF = $this;
    }
    public function __get($name)
    {
        return isset($this->_CONFIG[$name])?$this->_CONFIG[$name]:NULL;
    }
    public function __set($name, $value)
    {
        $this->_CONFIG[$name]=$value;
    }

}