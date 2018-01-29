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
    protected $my;

    public function __construct($response = null)
    {
        $this->my = $response;
    }

    public function end($html = '')
    {
        if (PHP_RUN_TYPE === 'php-fpm') {
            echo $html;
        } else {
            $this->my->end($html);
        }
    }
}