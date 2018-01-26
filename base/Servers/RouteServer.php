<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 15:08
 */

namespace Universe\Servers;


use FastRoute\RouteCollector;

class RouteServer
{
    /**
     * @var RouteCollector
     */
    protected static $route;

    /**
     * 设置服务
     *
     * @param RouteCollector $route
     */
    public static function setService(RouteCollector $route)
    {
        self::$route = $route;
    }

    public static function get($route, $handler)
    {
        self::$route->addRoute('GET',$route, $handler);
    }

    public static function post($route, $handler)
    {
        self::$route->addRoute('POST',$route, $handler);
    }

    public static function addRoute($httpMethod, $route, $handler)
    {
        self::$route->addRoute($httpMethod, $route, $handler);
    }
}