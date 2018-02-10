<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/8
 * Time: 16:04
 */

namespace App\Http\Middleware;


use Universe\Servers\RequestServer;
use Universe\Support\Middleware;

class LoginMiddleware extends Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
    public function handle(RequestServer $request, $next)
    {
        return $next($request);
    }
}