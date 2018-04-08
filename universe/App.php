<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:14
 */

namespace Universe;


use Dotenv\Dotenv;
use Universe\Support\Di;

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
     * 注册服务提供者
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
     * @return mixed
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
    public function start($serverName='httpServer')
    {
        $server = self::$di->getShared($serverName);
        $server->start();
    }
}