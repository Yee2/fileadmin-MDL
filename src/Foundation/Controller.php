<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 下午12:03
 */

namespace Yee\Foundation;


abstract class Controller
{
    protected $APP,$VIEW;
    public function __construct(\Yee\Contracts\Config $APP)

    {
        $this->APP = $APP;
        $this->VIEW = new View($APP);
    }
    public function Request(){
        return $this->APP->Request();
    }
    public function View():View
    {
        return $this->VIEW;
    }
    function NotFoundAction(){
        echo 'Not Found!';
    }
}