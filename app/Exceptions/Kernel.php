<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/30
 * Time: 14:43
 */

namespace App\Exceptions;


use App\Exceptions\Handlers\NotFoundHandler;
use App\Exceptions\Handlers\ShowErrorHandler;
use Universe\Exceptions\Handlers\LoggerHandler;
use Universe\Support\ExceptionKernel;

class Kernel extends ExceptionKernel
{
    /**
     * 注册异常处理;执行顺序,先入后出
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function register()
    {
        if( is_debug() ){
            // 如果调试，把错误展示出来
            $this->server->pushHandler(new ShowErrorHandler());
        }
        // 所有错误日记记录
        $this->server->pushHandler(new LoggerHandler());
        // 404 优先处理
        $this->server->pushHandler(new NotFoundHandler());
    }
}