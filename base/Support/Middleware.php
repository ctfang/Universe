<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午10:24
 */

namespace Universe\Support;


use Swoole\Http\Response;

abstract class Middleware
{
    /**
     * @param Response $request
     * @param Response $response
     * @param array $params
     * @return bool
     */
    abstract public function handle($request, $response, array &$params);
}