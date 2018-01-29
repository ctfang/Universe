<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 10:21
 */

namespace Universe\Servers;


use Universe\App;
use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

class HttpServer extends \swoole_http_server
{
    public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
    {
        parent::__construct($host, $port, $mode, $sock_type);

        $this->on('request',function ($request, $response){
            $request    = new Request($request);
            $response   = new Response($response);
            $this->request($request, $response);
        });
    }

    private function request($request, $response)
    {
        App::getDi()->get('dispatcher')->handle($request, $response);
    }
}