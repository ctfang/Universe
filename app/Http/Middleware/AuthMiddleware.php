<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 15:56
 */

namespace App\Http\Middleware;


use Universe\Support\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        dump('请求前');


        return $next();
    }
}