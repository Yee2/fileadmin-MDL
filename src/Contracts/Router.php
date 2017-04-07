<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 上午11:41
 */

namespace Yee\Contracts;


use Yee\Foundation\Controller;

interface Router
{
    public function Controller():Controller;
    public function setController(Controller $controller);
    public function Action();
    public function setAction(string $action);
    public function Run();

}