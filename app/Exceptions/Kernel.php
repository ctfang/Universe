<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/30
 * Time: 14:43
 */

namespace App\Exceptions;


use App\Exceptions\Handlers\ShowErrorHandler;
use Universe\Exceptions\Handlers\LoggerHandler;
use Universe\Support\ExceptionKernel;
use Whoops\Handler\PrettyPageHandler;

class Kernel extends ExceptionKernel
{
    /**
     * 注册异常处理
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        $this->server->pushHandler(new LoggerHandler());
        $this->server->pushHandler(new PrettyPageHandler());
    }
}