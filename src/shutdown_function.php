<?php
use Yee\Foundation\Session;
register_shutdown_function(function () {
    $e = error_get_last();
    $Session = Session::catch ();
    if (isset($e['type'])) {
        switch ($e['type']) {
            case E_PARSE:
                $msg = "PHP解析错误\n";
                $msg .= '错误文件：' . $e['file'] . "\n(" . $e['line'] . ":" . getLine($e) . ")";
                $Session->error = array(
                    'code' => E_PARSE,
                    'message' => $msg,
                    'errors' => array()
                );
                break;

            case E_ERROR:
                $msg = "PHP出现致命错误\n";
                $msg .= '错误文件：' . $e['file'] . "\n(" . $e['line'] . ":" . getLine($e) . ")";
                $Session->error = array(
                    'code' => E_ERROR,
                    'message' => $msg,
                    'errors' => array()
                );
                break;

            case E_WARNING:
                $msg = "PHP警告\n";
                $msg .= '错误文件：' . $e['file'] . "\n(" . $e['line'] . ":" . getLine($e) . ")";
                $Session->waring = array(
                    'code' => E_WARNING,
                    'message' => $msg,
                    'errors' => array()
                );
                break;

            case E_NOTICE:
                $msg = "PHP提醒\n";
                $msg .= '错误文件：' . $e['file'] . "\n(" . $e['line'] . ":" . getLine($e) . ")";
                $Session->notice = array(
                    'code' => E_NOTICE,
                    'message' => $msg,
                    'errors' => array()
                );
                break;

            default:
                # code...
                break;
        }
    }
    $Session->show();
});
function getLine(array $e){
    $arr=file($e['file']);
    $line=$e['line']-1;
    return trim($arr[$line]);
}