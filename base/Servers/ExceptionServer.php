<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 19:54
 */

namespace Universe\Servers;


use Universe\Exceptions\Handlers\Handler;

class ExceptionServer
{
    private $handler = [];

    public function pushHandler(Handler $handler)
    {
        $this->handler[] = $handler;
    }

    public function handler($exception, $request, $response)
    {
        foreach ($this->handler as $handler) {
            if ($handler instanceof Handler) {
                $handler->set($exception, $request, $response);
                $bool = $handler->handle();
                if ($bool === false) {
                    break;
                }
            }
        }
    }
}