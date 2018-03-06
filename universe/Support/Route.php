<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 15:08
 */

namespace Universe\Support;


use App\Http\Kernel;
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

    /**
     * 使用注解添加路由
     *
     * @param string $class
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function annotation($class)
    {
        $explode = "App\\Http\\Controllers\\";
        if (strpos($class, $explode) !== false) {
            $controller      = explode($explode, $class)[1];
        } else {
            $controller      = $class;
            $class           = $explode . $class;
        }
        $ReflectionClass = new \ReflectionClass($class);

        foreach ($ReflectionClass->getMethods() as $method) {
            if ($method->isPublic()) {
                $doc = $method->getDocComment();
                if (preg_match_all("/@\w+\([^\r\n]+/is", $doc, $match)) {
                    foreach (reset($match) as $docFun) {
                        $docFun = substr($docFun, 0, strrpos($docFun, ')'));
                        foreach (['get', 'post', 'put', 'patch', 'delete', 'options'] as $name) {
                            if (strpos($docFun, "@{$name}(") === 0) {
                                $code = str_replace("@{$name}(",
                                                    "\\Universe\\Support\\Route::{$name}(",
                                                    $docFun) . ",'{$controller}@{$method->getName()}');";
                                eval($code);
                            }
                        }
                    }
                }
            }
        }
        unset($ReflectionClass);
    }

    /**
     * 路由分组
     *
     * @param array $option
     * @param callable $callback
     * @author 明月有色 <2206582181@qq.com>
     */
    public static function group(array $option, callable $callback)
    {
        $defaultRouteOption = self::$routeOption;
        $RouteMiddleware    = (new Kernel())->getRouteMiddleware();
        // 设置中间件
        if (isset($option['middleware'])) {
            if (is_array($option['middleware'])) {
                foreach ($option['middleware'] as $key => $midName) {
                    $option['middleware'][$key] = $RouteMiddleware[$midName];
                }
                self::$routeOption['middleware'] = array_merge(self::$routeOption['middleware'], $option['middleware']);
            } else {
                $option['middleware']              = $RouteMiddleware[$option['middleware']];
                self::$routeOption['middleware'][] = $option['middleware'];
            }
        }
        // 前缀
        if (isset($option['prefix'])) {
            self::$routeOption['prefix'] = self::$routeOption['prefix'] . $option['prefix'];
        }
        // 命名空间
        if (isset($option['namespace'])) {
            self::$routeOption['namespace'] = self::$routeOption['namespace'] . "\\" . $option['namespace'] . "\\";
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
        $route = $routeOption['prefix'] . $route;
        self::$route->addRoute($httpMethod, $route, $routeOption);
    }
}