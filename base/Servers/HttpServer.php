<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 10:21
 */

namespace Universe\Servers;


use Universe\App;

class HttpServer extends \swoole_http_server
{
    public function __construct($host, $port, $mode = SWOOLE_PROCESS, $sock_type = SWOOLE_SOCK_TCP)
    {
        parent::__construct($host, $port, $mode, $sock_type);

        $this->on('request',function ($request, $response){
            $this->request($request, $response);
        });
    }

    private function request($request, $response)
    {
        try{
            App::getDi()->get('dispatcher')->handle($request, $response);
        }catch (\Exception $exception){
            // 命令行打印错误
            dump($exception);
        }
    }
}