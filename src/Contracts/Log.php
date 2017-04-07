<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午10:10
 */

namespace Yee\Contracts;


interface Log
{
    public function notice($message);
    public function error($message);
    public function warning($message);
}