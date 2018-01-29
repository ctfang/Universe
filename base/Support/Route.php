<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 15:08
 */

namespace Universe\Support;


use FastRoute\RouteCollector;

class Route
{
    /**
     * @var RouteCollector
     */
    protected static $route;

    protected static $routeOption = [
        'middleware' => [],
        'prefix'     => '',
        'namespace'  => "\\App\\Http\\Controllers\\",
    ];

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
        self::addRoute('GET', $route, $handler);
    }

    public static function post($route, $handler)
    {
        self::addRoute('POST', $route, $handler);
    }

    public static function put($route, $handler)
    {
        self::addRoute('PUT', $route, $handler);
    }

    public static function patch($route, $handler)
    {
        self::addRoute('PATCH', $route, $handler);
    }

    public static function delete($route, $handler)
    {
        self::addRoute('DELETE', $route, $handler);
    }

    public static function options($route, $handler)
    {
        self::addRoute('OPTIONS', $route, $handler);
    }

    public static function group(array $option, callable $callback)
    {
        $defaultRouteOption = self::$routeOption;
        // 设置中间件
        if( isset($option['middleware']) ){
            if( is_array($option['middleware']) ){
                self::$routeOption['middleware'] = array_merge(self::$routeOption['middleware'],$option['middleware']);
            }else{
                self::$routeOption['middleware'][] = $option['middleware'];
            }
        }
        // 前缀
        if( isset($option['prefix']) ){
            self::$routeOption['prefix'] = self::$routeOption['prefix'].$option['prefix'];
        }
        // 命名空间
        if( isset($option['namespace']) ){
            self::$routeOption['namespace'] = self::$routeOption['namespace']."\\".$option['namespace']."\\";
        }

        $callback();

        self::$routeOption = $defaultRouteOption;
    }

    /**
     * 统一封装
     *
     * @param $httpMethod
     * @param $route
     * @param $handler
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function addRoute($httpMethod, $route, $handler)
    {
        $routeOption = self::$routeOption;

        list($routeOption['controller'], $routeOption['action']) = explode('@', $handler);
        $route = $routeOption['prefix'].$route;
        self::$route->addRoute($httpMethod, $route, $routeOption);
    }
}