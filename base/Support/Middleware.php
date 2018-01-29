<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:24
 */

namespace Universe\Support;


use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

abstract class Middleware
{
    /**
     * @param Request $request
     * @param $next
     * @return Response
     */
     abstract public function handle($request,$next);
}