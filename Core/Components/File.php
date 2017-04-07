<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-4-7
 * Time: 上午10:56
 */

namespace FA\Core\Components;
use FA\Core\Contracts\File as BaseFile;

class File
{
    private $path;
    function __construct($path)
    {
        if(!file_exists($path)){
            throw new \Exception('file doesn\'t found');
        }
        $this->path = $path;
    }
    function isFile(){
        return is_file($this->path);
    }
    function isDir(){
        return is_dir($this->path);
    }
    function name(){
        return basename($this->path);
    }
    function dir(){
        return dirname($this->path);
    }
    function fileIcon(){
        $a = explode('.',basename($this->path));
        if(count($a) < 2){
            return "fa fa-file";
        }
        $ext=strtolower(end($a));
        switch (true){
            case in_array($ext,['zip','rar','gz','xz','jar']):
                return "fa fa-file-archive-o";
            case in_array($ext,['mp3'])://音乐类文件
                return "fa fa-file-audio-o";
            case in_array($ext,['html','htm','php','java','go','css','c','cpp'])://
                return "fa fa-file-code-o";
            case in_array($ext,['xlsx','xlsm','xltx','xltm'])://表格类文件
                return "fa fa-file-excel-o";
            case in_array($ext,['png','jpg','jpeg','gif','bmp']):
                return "fa fa-file-image-o";
            case in_array($ext,['mp4','flv']):
                return "fa fa-file-movie-o";
            case in_array($ext,['pdf']):
                return "fa fa-file-pdf-o";
            case in_array($ext,['pptx','pptm','ppt']):
                return "fa fa-file-powerpoint-o";
            case in_array($ext,['txt','md']):
                return "fa fa-file-text-o";
            case in_array($ext,['doc','docx']):
                return "fa fa-file-word-o";
            default:
                return "fa fa-file";
        }
    }
    function fileSize(){
        return $this->formatBytes(filesize($this->path));
    }
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('Byte', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
    function lastChange(){
        return date('M d,Y H:i:s',filemtime($this->path));
    }
}