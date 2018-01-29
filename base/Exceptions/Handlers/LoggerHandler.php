<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/26
 * Time: 21:03
 */

namespace Universe\Exceptions\Handlers;

use Monolog\Logger;
use Universe\App;

class LoggerHandler extends Handler
{
    /**
     * @return Logger
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getLogger()
    {
        return App::getDi()->get('logger');
    }

    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        $exception     = $this->exception;
        $errorCode     = $exception->getCode();
        $logger        = $this->getLogger();
        $errorString   = $exception->getMessage()." : uri={$this->request->getUri()}\n[stacktrace]\n".$exception->getTraceAsString();
        switch ($errorCode) {
            case E_WARNING:
                $logger->warning($errorString);
                break;
            case E_NOTICE:
                $logger->notice($errorString);
                break;
            case E_ERROR:
                $logger->error($errorString);
                break;
            default :
                $logger->error($errorString);
                break;
        }
    }
}