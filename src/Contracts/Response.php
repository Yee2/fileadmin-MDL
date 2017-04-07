<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午9:59
 */

namespace Yee\Contracts;


interface Response
{
    public function setCode(int $num);
    public function cookie($name,$value);
    public function header($header);
}