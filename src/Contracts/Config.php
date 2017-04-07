<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 上午11:38
 */

namespace Yee\Contracts;


interface Config
{
    public function setRouter(Router $router);
    public function Router():Router;
    public function AppName():string;
    public function Request():Request;
    public function setRequest(Request $request);
    public static function get();
}