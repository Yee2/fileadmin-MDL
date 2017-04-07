<?php
require 'vendor/autoload.php';
// header('Content-type: application/vnd.api+json');
header('Access-Control-Allow-Origin: *');


/*
 * 首先，这是一个单应用框架，定位快速开发
 * 其次，单入口文件，也就是index.php或者其他
 * 第一步就是加载应用配置
 * 第二步将配置传送给应用
 * 第三步运行应用
 */
ini_set("open_basedir",dirname(dirname(__DIR__)));
(new Yee\App(
    new Yee\Foundation\Config(include 'setting.php')
    )
)->run();
//第一步，读取应用配置