<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:16
 */

namespace App\Http;

use App\Http\Middleware\DatabaseMiddleware;
use App\Http\Middleware\LoginMiddleware;
use Universe\Middleware\DebugDumpMiddleware;
use Universe\Middleware\DebugReloadMiddleware;
use Universe\Support\HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 全局中间件，应用于所有路由的中间件
     *
     * 调试性的中间件必须在前面，在生产环境可以去掉
     * 热更新中间件在非守护进程下，是不会执行重启的
     *
     * @var array
     */
    protected $middleware = [
        DebugDumpMiddleware::class,// 调试的辅助，dump函数输出重定向
        DatabaseMiddleware::class,// 数据库链接管理，载入配置
    ];


    /**
     * 注册路由的中间件
     *
     * 中间件可以用在不同路由分组上 "别名"=》"中间件"
     *
     * @var array
     */
    protected $routeMiddleware = [
        'login'=>LoginMiddleware::class,
    ];
}