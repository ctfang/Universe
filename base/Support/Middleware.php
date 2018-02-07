<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:24
 */

namespace Universe\Support;


use Universe\Servers\RequestServer;

abstract class Middleware
{
    /**
     * @param RequestServer $request
     * @param $next
     */
     abstract public function handle(RequestServer $request,$next);
}