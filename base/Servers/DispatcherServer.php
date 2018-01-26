<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 20:48
 */

namespace Universe\Servers;


use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Universe\App;
use Universe\Exceptions\NotFoundException;

class DispatcherServer
{
    protected $dispatcher;

    public function __construct()
    {
        /**
         * 载入业务路由
         */
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) {
            RouteServer::setService($route);
            include_once App::getPath('/config/route.php');
        });
    }

    /**
     * 路由解析
     *
     * @param Request $request
     * @param Response $response
     * @throws NotFoundException
     */
    public function handle(Request $request, Response $response)
    {
        $method = $request->server['request_method'];
        $uri    = $request->server['request_uri'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);


        $routeInfo = $this->dispatcher->dispatch($method, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundException('404 Not Found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new NotFoundException('405 Method Not Allowed');
                break;
            case Dispatcher::FOUND:
                $this->dispatch($request, $response, $routeInfo);
                break;
        }
    }

    /**
     * 控制器调度
     *
     * @param Request $request
     * @param Response $response
     * @param $routeInfo
     */
    private function dispatch(Request $request, Response $response, $routeInfo)
    {
        list($controller, $action) = explode('@', $routeInfo[1]);
        $requestParam = $routeInfo[2];
        $controller = "\\App\\Http\\Controllers\\{$controller}";

        $ReflectionClass  = new \ReflectionClass($controller);
        $ReflectionMethod = $ReflectionClass->getMethod($action);

        $paraData = [];
        // 路由参数传入
        foreach ($ReflectionMethod->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            if( isset($requestParam[$paramName]) ){
                $paraData[] = $requestParam[$paramName];
                unset($requestParam[$paramName]);
            }else{
                $paraData[] = null;
            }
        }

        call_user_func_array([new $controller($request,$response), $action], $paraData);
    }
}