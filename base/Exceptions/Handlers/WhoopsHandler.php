<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/5
 * Time: 18:38
 */

namespace Universe\Exceptions\Handlers;


use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

abstract class WhoopsHandler extends \Whoops\Handler\Handler
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    public function set($exception, Request $request, Response $response)
    {
        $this->exception = $exception;
        $this->request = $request;
        $this->response = $response;
    }
}