<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:14
 */

namespace Universe;


use Dotenv\Dotenv;
use Universe\Providers\AbstractServiceProvider;
use Universe\Support\Config;
use Universe\Support\Di;

class App
{
    private static $path;
    protected static $di;

    public function  __construct($root)
    {
        self::$path = $root;
        // 优先加载环境变量
        if( file_exists(self::getPath('/.env')) ){
            (new Dotenv($root))->load();
        }
        // Di类
        self::$di = new Di();
        self::$di->set('config',function (){
            return new Config();
        });
    }

    /**
     * 获取相对项目的路径
     *
     * @param $path
     * @return string
     */
    public static function getPath($path='')
    {
        return self::$path.$path;
    }

    public static function getDi()
    {
        return self::$di;
    }

    /**
     * 初始化服务
     *
     * @param $arrConfig
     */
    public function initializeServices($arrConfig)
    {
        foreach ($arrConfig as $className){
            (new $className(self::$di))->register();
        }
    }

    /**
     * 启动服务
     */
    public function start()
    {
        if( PHP_RUN_TYPE=='swoole' ){
            self::$di->get('http')->start();
        }else{
            /**
             * 兼容赋值
             */
            $request  = new \Universe\Swoole\Http\Request();
            $response = new \Universe\Swoole\Http\Response();

            self::$di->get('dispatcher')->handle($request, $response);
        }
    }
}