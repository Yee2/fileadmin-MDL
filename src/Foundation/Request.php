<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 下午12:23
 */

namespace Yee\Foundation;


class Request implements \Yee\Contracts\Request
{
    protected $SERVER;
    public function __construct()
    {
        $this->SERVER = $_SERVER;
    }

    /**
     * @return string 请求路径，不包含参数
     */
    public function path():string {
        return $this->SERVER['SCRIPT_NAME'];
    }

    /**
     * @return string 请求文件，不包含参数和文件夹
     */
    public function file():string{
        return basename($this->path());
    }

    /**
     * @return string 请求参数，不包含文件路径
     */
    public function query():string {
        return $this->SERVER['QUERY_STRING'] ;
    }

    /**
     * @return string 完整的请求，包含参数和完整路径
     */
    public function uri():string {
        return $this->SERVER['REQUEST_URI'];
    }

    /**
     * @return string 请求的主机名
     */
    public function host():string{
        return $this->SERVER['HTTP_HOST'];
    }

    /**
     * @return string 请求者的真实IP地址
     */
    public function ip():string{
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }

    /**
     * @param $name 获取GET或者POST参数,POST优先
     */
    public function __get($name)
    {
        return ($_POST[$name] || $_GET[$name] || NULL);
    }
}