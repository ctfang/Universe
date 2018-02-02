<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/31
 * Time: 15:28
 */

namespace Universe\Middleware;


use Universe\Support\Middleware;
use Universe\Swoole\Http\Request;

class DebugDumpMiddleware extends Middleware
{
    /**
     * 调试模式下所有输出都在缓冲区
     *
     * @param Request $request
     * @param $next
     */
    public function handle(Request $request, $next)
    {
        if( is_debug() ){
            ob_start();
        }
        return$next($request);
    }
}