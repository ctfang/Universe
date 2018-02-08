<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/8
 * Time: 15:29
 */

namespace Universe\Middleware;


use Universe\App;
use Universe\Servers\RequestServer;
use Universe\Support\Middleware;

class DebugReloadMiddleware extends Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        $next = $next($request);
        if( is_debug() && App::get('config')->get('server.http.set.daemonize') ){
            // 调试模式，并且是守护模式
            App::get('server')->reload();
        }
        return $next;
    }
}