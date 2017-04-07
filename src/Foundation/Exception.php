<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-4-3
 * Time: 上午10:42
 */

namespace Yee\Foundation;


class Exception
{

    function __construct(\Exception $e)
    {
        $Trace = join("<br>\n",array_map(function ($trace){
            return sprintf("[%d]%s#%s(%s)",$trace['line'],$trace['file'],$trace['function'],join(',',$trace['args']));
        },$e->getTrace()));
        echo <<<HTML
    捕获运行时的异常：{$e->getMessage()}<br>
    在文件:{$e->getFile()}({$e->getLine()})<br>
    错误追踪:{$Trace}<br>
HTML;

    }
}