<?php
namespace Yee\Foundation;
use Yee\Contracts\Router as BaseRouter;
class Router implements BaseRouter
{


    protected $CONTROLLER,$ACTION,$APP;
    public function Action()
    {
        return $this->ACTION;
    }
    public function setAction(string  $action)
    {
        $this->ACTION = $action;
    }
    public function Controller(): Controller
    {
        return $this->CONTROLLER;
    }
    public function setController(Controller $controller)
    {
        $this->CONTROLLER = $controller;
    }

    function defaultController(){
        return 'defaultController';
    }
    function defaultAction(){
        return 'Index';
    }
    function NotFoundController(){
        return '\\Yee\\Controller\\NotFound';
    }

    function __construct(Config $app)
    {
        $this->APP = $app;

    }

    function NotFoundAction(){
        return 'NotFound';
    }
    function Run(){
        //读取请求参数，解析出控制器，行为，参数
        list($Controller,$Action,$QueryArray) = $this->parseFromRequest($this->APP->Request());
        if(!$this->isSet()){

            $this->setController(new $Controller($this->APP));
            $this->setAction($Action);
        }
        if(!method_exists($this->Controller(),$this->Action()."Action")){
            $this->setAction($this->NotFoundAction());
        }
        call_user_func_array(array($this->Controller(),$this->Action()."Action"), $QueryArray);

    }
    private function parseFromRequest(Request $request):array{
        $queryArray =   explode("/",urldecode(explode("#",substr($request->uri(),strlen($request->path())+1))[0]));
        $Controller =   '\\'.$this->APP->AppName().'\\Controller\\'.(array_shift($queryArray)?:$this->defaultController());
        $Action     =   array_shift($queryArray)?:$this->defaultAction();
        if(!class_exists($Controller)){
            $this->APP->Log()->notice("控制器不存在:".$Controller);
            $Controller = $this->NotFoundController($Controller);
        }
        return [$Controller,$Action,$queryArray];
    }
    private function isSet(){
        return ($this->CONTROLLER || false);
    }
}
