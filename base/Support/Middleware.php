<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:24
 */

namespace Universe\Support;


use Universe\Swoole\Http\Request;

abstract class Middleware
{
    /**
     * @param Request $request
     * @param $next
     */
     abstract public function handle(Request $request,$next);
}