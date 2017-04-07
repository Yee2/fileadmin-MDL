<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午10:13
 */

namespace Yee\Foundation;
use Yee\Contracts\Log as BaseLog;

class Log implements BaseLog
{
    private $logs = [];
    public function __construct($APP = null)
    {
    }

    public function error($message)
    {
        array_push($this->logs,sprintf("[Error %s]:%s",date("M d H:i:s"),$message));
    }
    public function notice($message)
    {
        array_push($this->logs,sprintf("[Notice %s]:%s",date("M d H:i:s"),$message));
    }
    public function warning($message)
    {
        array_push($this->logs,sprintf("[Warning %s]:%s",date("M d H:i:s"),$message));
    }
    public function print(){
        echo "<!--\n";
        foreach ($this->logs as $log){
            echo $log."\n";
        }
        echo "\n-->";
    }
}