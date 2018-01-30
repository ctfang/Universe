<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:23
 */

namespace App\Http\Middleware;

use Universe\Support\Middleware;
use Universe\Swoole\Http\Request;

class CounterMiddleware extends Middleware
{
    /**
     * @param  Request $request
     * @param $next
     * @return Request
     */
    public function handle(Request $request, $next)
    {
        return $next($request);
    }
}