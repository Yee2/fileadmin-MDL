<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 下午3:25
 */

namespace Yee\Controller;
use Yee\Foundation\Controller as BaseController;

class NotFound extends BaseController
{
    public function __call($name,$arg){
        echo "错误请求";
    }
}