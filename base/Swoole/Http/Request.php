<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:44
 */

namespace Universe\Swoole\Http;


class Request extends \Swoole\Http\Request
{
    public function __construct()
    {
        $this->get  = $_GET;
        $this->post = $_POST;
        foreach ($_SERVER as $key=>$value){
            $this->server[strtolower($key)] = $value;
        }
    }
}