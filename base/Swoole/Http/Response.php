<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:43
 */

namespace Universe\Swoole\Http;


class Response extends \Swoole\Http\Response
{
    public function end($html = '')
    {
        echo $html;
    }
}