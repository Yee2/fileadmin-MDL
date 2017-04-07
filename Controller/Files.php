<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午10:41
 */

namespace FA\Controller;


use FA\Core\Components\File;
use Yee\Foundation\Controller;
use Yee\Foundation\View;

class Files extends Controller
{
    public function ListAction(){
        $args = func_get_args();
        if($args[0] == '..'){
            $path = dirname(__DIR__);
        }else{
            $path = count($args) > 0 ? '/'.join('/',$args) : __DIR__;
        }
        if(!$dir = opendir($path)){
            throw new \Exception("打开目录发生错误:".$path);
        }

        $path = realpath($path);
        $Dirs = [];$Files = [];
        while (($file = readdir($dir)) !== false){
            if($file == "." or $file == ".." ){
                continue;
            }
            $realpath= realpath($path.'/'.$file);
            if(is_dir($realpath)){
                $Dirs[]=self::DirInfo($realpath);
            }else{
                $Files[]=self::FileInfo($realpath);
            }
        }
        closedir($dir);
        $view = new View($this->APP);
        $view->Files = $Files;
        $view->Dirs = $Dirs;
        $view->path = $path;
        $view->name = basename($path);
        $view->Favorites = [
            [
                'name'=>'测试收藏夹',
                'path'=>'/home/tristana/NGNL/php-json/vendor/'
            ],
            [
                'name'=>'测试收藏夹',
                'path'=>'/home/tristana/NGNL/php-json/'
            ],
        ];
        $view->render("json");
    }
    static function FileInfo($path){
        $file = new File($path);
        return [
            'path'  =>$path,
            'name'  =>$file->name(),
            'dir'   =>$file->dir(),
            'size'  =>$file->fileSize(),
            'icon'  =>$file->fileIcon(),
            'date'  =>$file->lastChange(),
        ];
    }
    static function DirInfo($path){
        return [
          'name'    =>basename($path),
          'path'    =>$path,
        ];
    }
}