<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/30
 * Time: 14:43
 */

namespace App\Exceptions;


use App\Exceptions\Handlers\NotFoundHandler;
use Universe\Exceptions\Handlers\LoggerHandler;
use Universe\Support\ExceptionKernel;
use Whoops\Handler\PrettyPageHandler;

class Kernel extends ExceptionKernel
{
    /**
     * 注册异常处理
     *
     * 执行顺序 先入后出
     * $this->server->pushHandler(new LoggerHandler());
     * $this->server->pushHandler(new ShowErrorHandler());
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        if( is_debug() ){
            // 如果调试，把错误展示出来
            $PrettyPageHandler = new PrettyPageHandler();
            $PrettyPageHandler->handleUnconditionally(true);
            $this->server->pushHandler( $PrettyPageHandler );
        }
        // 所有错误日记记录
        $this->server->pushHandler(new LoggerHandler());
        // 404 优先处理
        $this->server->pushHandler(new NotFoundHandler());
    }
}