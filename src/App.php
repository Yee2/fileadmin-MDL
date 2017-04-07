<?php
/**
 * Created by PhpStorm.
 * User: tristana
 * Date: 17-3-28
 * Time: 上午11:37
 */

namespace Yee;


use Yee\Contracts\Config;
use Yee\Foundation\Exception;

class App
{
    private $APP;
    /**
     * App constructor.
     * @param Config $config 应用配置配置
     */
    public function __construct(Config $app)
    {
        $this->APP = $app;
    }
    public function Run(){
        try {
            $this->APP->Router($this->APP)->Run();
//            $this->APP->Log()->print();
        }
        catch (\Exception $e) {
            new Exception($e);
        }
    }
}