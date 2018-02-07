<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:14
 */

namespace Universe;


use Dotenv\Dotenv;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Universe\Servers\ResponseServer;
use Universe\Support\Di;
use Universe\Servers\RequestServer;

class App
{
    private static $path;
    private static $di;

    public function __construct($root)
    {
        self::$path = $root;
        // 优先加载环境变量
        if (file_exists(self::getPath('/.env'))) {
            (new Dotenv($root))->load();
        }
        self::$di = new Di();
    }

    /**
     * 获取相对项目的路径 ，根目录不带 /
     *
     * @param string $path
     * @return string
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function getPath($path = '')
    {
        return self::$path . $path;
    }

    /**
     * 获取DI
     *
     * @return Di
     * @author 明月有色 <2206582181@qq.com>
     */
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
        foreach ($arrConfig as $className) {
            (new $className(self::$di))->register();
        }
    }

    /**
     * 获取服务
     *
     * @param $serverName
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function get($serverName)
    {
        return self::$di->get($serverName);
    }

    /**
     * @param $serverName
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function getShared($serverName)
    {
        return self::$di->getShared($serverName);
    }

    /**
     * 启动服务
     *
     * @author 明月有色 <2206582181@qq.com>
     */
    public function start()
    {
        /**
         * 启动端口监听服务
         * PHP_RUN_TYPE 在cli分类上再区分运行类别
         */
        if (PHP_RUN_TYPE == 'swoole') {
            $server = self::$di->getShared('server');
            $server->start();
        } else {
            // fpm and 调试模式
            $request     = App::getShared('request');
            $response    = App::getShared('response');
            $request->set(new Request());
            $response->set(new Response());
            self::$di->get('dispatcher')->handle($request, $response);
        }
    }
}