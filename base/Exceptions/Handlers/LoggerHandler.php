<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/26
 * Time: 21:03
 */

namespace Universe\Exceptions\Handlers;


class LoggerHandler extends Handler
{
    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        $this->response->end($this->exception->getMessage());
    }
}