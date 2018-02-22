<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/29
 * Time: 15:56
 */

namespace App\Http\Middleware;


use Universe\App;
use Universe\Support\Middleware;
use Universe\Servers\RequestServer;

class DatabaseMiddleware extends Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        // 载入数据库配置和实例化
        App::getShared('db');

        return $next($request);
    }
}