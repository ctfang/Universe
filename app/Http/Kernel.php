<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:16
 */

namespace App\Http;

use Universe\Middleware\DebugDumpMiddleware;
use Universe\Support\HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * 全局中间件，应用于所有路由的中间件
     *
     * @var array
     */
    protected $middleware = [
        DebugDumpMiddleware::class,
    ];


    /**
     * 注册路由的中间件
     *
     * 中间件可以用在不同路由分组上 "别名"=》"中间件"
     *
     * @var array
     */
    protected $routeMiddleware = [
        'login'=>''
    ];
}