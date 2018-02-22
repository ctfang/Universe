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
     * @param RequestServer $request
     * @param ResponseServer $response
     * @return mixed
     * @throws NotFoundException
     */
    public function handle(RequestServer $request, ResponseServer $response)
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
            $this->handleException($request,$response,$exception);
        }catch (\Error $exception){
            $this->handleException($request,$response,$exception);
        }
    }

    /**
     * 异常处理
     *
     * @param $request
     * @param $response
     * @param $exception
     * @author 明月有色 <2206582181@qq.com>
     */
    private function handleException($request,$response,$exception)
    {
        $exception->request  = $request;
        $exception->response = $response;
        App::getShared('exception')->handleException($exception);
    }

    /**
     * 控制器调度
     *
     * @param RequestServer $request
     * @param ResponseServer $response
     * @param $routeInfo
     * @return mixed
     */
    private function dispatch(RequestServer $request, ResponseServer $response, $routeInfo)
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
        if ($data instanceof RequestServer) {
            return $this->handle($request,$response);
        }else{
            return $data;
        }
    }

    /**
     * @return \Closure
     * @author 明月有色 <2206582181@qq.com>
     */
    protected function getInitialSlice()
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                return (new $pipe())->handle($passable, $stack);
            };
        };
    }

    /**
     * 控制器闭包
     *
     * @param $request
     * @param $response
     * @param $controller
     * @param $action
     * @param $paraData
     * @return \Closure
     * @author 明月有色 <2206582181@qq.com>
     */
    protected function getDestination($request, $response, $controller, $action, $paraData)
    {
        return function () use ($controller, $request, $response, $action, $paraData) {
            return call_user_func_array([new $controller($request, $response), $action], $paraData);
        };
    }

    /**
     * @param \Closure $destination
     * @return \Closure
     * @author 明月有色 <2206582181@qq.com>
     */
    protected function prepareDestination(\Closure $destination)
    {
        return function ($passable) use ($destination) {
            return $destination($passable);
        };
    }
}