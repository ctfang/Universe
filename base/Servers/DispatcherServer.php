<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 20:48
 */

namespace Universe\Servers;


use App\Http\Kernel;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Universe\App;
use Universe\Exceptions\MethodNotAllowedException;
use Universe\Exceptions\NotFoundException;
use Universe\Support\Route;
use Universe\Swoole\Http\Request;
use Universe\Swoole\Http\Response;

class DispatcherServer
{
    protected $dispatcher;

    public function __construct()
    {
        /**
         * 载入业务路由
         */
        $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $route) {
            try {
                Route::setService($route);
                include_once App::getPath('/config/route.php');
            } catch (\Exception $exception) {
                $errorString   = $exception->getMessage()."\n[stacktrace]\n".$exception->getTraceAsString();
                App::get('logger')->error($errorString);
            }
        });
    }

    /**
     * 路由解析、调度入口
     *
     * @param Request $request
     * @param Response $response
     * @return mixed
     * @throws NotFoundException
     */
    public function handle(Request $request, Response $response)
    {
        try {
            $method = $request->getMethod();
            $uri    = $request->getUri();

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
                    throw new MethodNotAllowedException('405 Method Not Allowed');
                    break;
                case Dispatcher::FOUND:
                    return $this->dispatch($request, $response, $routeInfo);
                    break;
            }
        } catch (\Exception $exception) {
            App::get('exception')->handleException($exception, $request, $response);
        }catch (\Error $exception){
            App::get('exception')->handleException($exception, $request, $response);
        }
    }

    /**
     * 控制器调度
     *
     * @param Request $request
     * @param Response $response
     * @param $routeInfo
     * @return mixed
     */
    private function dispatch(Request $request, Response $response, $routeInfo)
    {
        $routeOption      = $routeInfo[1];
        $requestParam     = $routeInfo[2];
        $controller       = "\\App\\Http\\Controllers\\" . $routeOption['controller'];
        $action           = $routeOption['action'];
        $ReflectionClass  = new \ReflectionClass($controller);
        $ReflectionMethod = $ReflectionClass->getMethod($action);

        $paraData = [];
        // 路由参数传入
        foreach ($ReflectionMethod->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            if (isset($requestParam[$paramName])) {
                $paraData[] = $requestParam[$paramName];
                unset($requestParam[$paramName]);
            } else {
                $paraData[] = null;
            }
        }
        $midKernel = new Kernel();
        // 全局中间件
        $middleware  = $midKernel->getMiddleware();
        $middleware  = $middleware + $routeOption['middleware'];
        $destination = $this->getDestination($request, $response, $controller, $action, $paraData);

        // 中间件执行
        $pipeline = array_reduce(
            array_reverse($middleware),
            $this->getInitialSlice(),
            $this->prepareDestination($destination)
        );
        $data     = $pipeline($request);
        if ($data instanceof Request) {
            return $this->handle($request,$response);
        }elseif ($data instanceof Response){
            return $data;
        }elseif($data){
            App::get('output')->end($data, $response);
        }
    }

    protected function getInitialSlice()
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                return (new $pipe())->handle($passable, $stack);
            };
        };
    }

    protected function getDestination($request, $response, $controller, $action, $paraData)
    {
        return function () use ($controller, $request, $response, $action, $paraData) {
            return App::get('output')->end(
                call_user_func_array([new $controller($request, $response), $action], $paraData),
                $response
            );
        };
    }

    protected function prepareDestination(\Closure $destination)
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }
}