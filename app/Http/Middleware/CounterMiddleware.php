<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:23
 */

namespace App\Http\Middleware;


use Swoole\Http\Response;
use Universe\Support\Middleware;

class CounterMiddleware extends Middleware
{
    /**
     * 统计服务启动后，访问次数
     *
     * @var int
     */
    public static $num = 0;

    public function handle($request, $next)
    {
        $response = $next($request);
        dump('请求后' );
        return $response;
    }
}