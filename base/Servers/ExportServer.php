<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 16:35
 */

namespace Universe\Servers;


use Universe\Swoole\Http\Response;

class ExportServer
{
    public function end($data,Response $response)
    {
        if(is_array($data)){
            $response->end(json_encode($data,JSON_UNESCAPED_UNICODE));
        }elseif ( is_object($data) ){
            $response->end(json_encode($data,JSON_UNESCAPED_UNICODE));
        }elseif($data!==null){
            $response->end($data);
        }
    }
}