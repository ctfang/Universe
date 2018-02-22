<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 21:03
 */

namespace Universe\Exceptions\Handlers;

use Monolog\Logger;
use Universe\App;
use Whoops\Handler\Handler;

class LoggerHandler extends Handler
{
    /**
     * @return Logger
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getLogger()
    {
        return App::get('logger');
    }

    /**
     * @return int|null A handler may return nothing, or a Kernel::HANDLE_* constant
     */
    public function handle()
    {
        $exception   = $this->getException();
        $errorCode   = $exception->getCode();
        $logger      = $this->getLogger();
        $request     = $exception->request;
        $errorString = $exception->getMessage() . " : uri={$request->getUri()}\n[stacktrace]\n" . $exception->getTraceAsString();
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