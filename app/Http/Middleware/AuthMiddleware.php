<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 15:56
 */

namespace App\Http\Middleware;


use Universe\Support\Middleware;
use Universe\Swoole\Http\Request;

class AuthMiddleware extends Middleware
{
    /**
     * @param Request $request
     * @param $next
     */
    public function handle(Request $request, $next)
    {
        return $next($request);
    }
}