<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 下午12:08
 */

namespace Yee\Contracts;


interface Request
{
    public function path():string ; //请求路径，不包含参数
    public function file():string ; //请求文件，不包含参数和文件夹
    public function query():string ;//请求参数，不包含文件路径
    public function uri():string ;  //完整的请求，包含参数和完整路径
    public function host():string;  //请求的主机名
    public function ip():string;    //请求者的真实IP地址
    public function __get($name);   //获取GET或者POST参数，POST优先
}