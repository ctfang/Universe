<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 15:56
 */

namespace App\Http\Middleware;


use Universe\App;
use Universe\Support\Middleware;
use Universe\Swoole\Http\Request;

class DatabaseMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param $next
     */
    public function handle(Request $request, $next)
    {
        // 载入数据库配置和实例化

        App::getShared('db');

        $response = $next($request);

        // 如果数据库链接不足，可以取消注释，在请求后关闭链接
        // $db = App::getShared('db');
        // $db->getConnection()->setPdo(null);

        return $response;
    }
}