<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 21:03
 */

namespace Universe\Exceptions\Handlers;


use Universe\App;
use Universe\Servers\RequestServer;
use Whoops\Handler\PlainTextHandler;

class LoggerHandler extends PlainTextHandler
{
    /**
     * @return int|null A handler may return nothing, or a Kernel::HANDLE_* constant
     */
    public function handle()
    {
        $response = $this->generateResponse();

        App::get('logger')->error("uri:".$this->getRequest()->getUri().PHP_EOL.$response);
    }


    /**
     * @return RequestServer
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getRequest()
    {
        return $this->getException()->request;
    }
}