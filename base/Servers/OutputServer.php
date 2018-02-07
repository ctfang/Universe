<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 16:35
 */

namespace Universe\Servers;


use Universe\Swoole\Http\ResponseServer;

class OutputServer
{
    public function end($data,ResponseServer $response)
    {
        if(is_array($data)){
            $response->header('Content-Type','application/json');
            $response->end(json_encode($data,JSON_UNESCAPED_UNICODE));
        }elseif ( is_object($data) ){
            $response->header('Content-Type','application/json');
            $response->end(json_encode($data,JSON_UNESCAPED_UNICODE));
        }elseif($data!==null){
            $response->header('Content-Type','text/html; charset=UTF-8');
            $response->end($data);
        }
    }
}