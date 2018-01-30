<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/30
 * Time: 14:56
 */

namespace Universe\Support;


use Universe\Servers\ExceptionServer;

abstract class ExceptionKernel
{
    /**
     * @var ExceptionServer
     */
    protected $server;

    /**
     * ExceptionKernel constructor.
     * @param $server
     */
    public function __construct($server)
    {
        $this->server = $server;
    }

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
    abstract public function register();
}