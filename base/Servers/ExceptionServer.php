<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 19:54
 */

namespace Universe\Servers;


class ExceptionServer
{
    private $handler = [];

    public function pushHandler($handler)
    {
        array_unshift($this->handler,$handler);
    }

    public function handleException($exception, $request, $response)
    {
        foreach ($this->handler as $handler) {
            if ($handler) {
                $handler->set($exception, $request, $response);
                $bool = $handler->handle();
                if ($bool === false) {
                    break;
                }
            }
        }
    }

    /**
     * 启动扑抓异常服务
     *
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        set_error_handler([$this,'handleError'], E_ALL | E_STRICT);
        set_exception_handler([$this,'handleException']);
    }

    /**
     * try 不能捕捉的异常转换
     *
     * @param $level
     * @param $message
     * @param null $file
     * @param null $line
     * @throws \ErrorException
     * @author 明月有色 <2206582181@qq.com>
     */
    public function handleError($level, $message, $file = null, $line = null)
    {
        throw new \ErrorException($message, $level,$level, $file, $line);
    }
}