<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/28
 * Time: 下午4:46
 */

namespace Universe\Support;


class HttpKernel
{
    /**
     * 全局中间件，应用于所有路由的中间件
     *
     * @var array
     */
    protected $middleware;


    /**
     * 注册路由的中间件
     *
     * 中间件可以用在不同路由分组上
     *
     * @var array
     */
    protected $routeMiddleware;

    /**
     * @return array
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * @return array
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getRouteMiddleware()
    {
        return $this->routeMiddleware;
    }
}