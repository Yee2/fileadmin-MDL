<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-29
 * Time: 下午6:31
 */

namespace Yee\Model;


use Yee\Foundation\Model;

class User extends Model
{
    function Get(){
        $Users = [];
        $res = $this->query("SELECT * FROM `country`");
        if (false === $res){
            return "发生错误";
        }
        while ($User = $res->fetch()){
            yield $User;
        }
        return true;
    }
}