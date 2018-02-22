<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:44
 */

namespace Universe\Servers;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\FileSessionHandler;
use Illuminate\Session\Store;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Universe\App;
use Universe\Exceptions\NoRecursiveException;

class RequestServer extends Request
{
    private $filters;

    /**
     * @var Request
     */
    private $system;
    private $session=false;

    /**
     * @var Response
     */
    public  $response;

    /**
     * 过滤函数初始化
     */
    public function __construct()
    {
        foreach (filter_list() as $value) {
            $this->filters[$value] = filter_id($value);
        }
    }

    /**
     * 初始化，对命令行和fpm模式下兼容运行
     *
     * @param Request $request
     * @param Response $response
     */
    public function set(Request $request, Response $response)
    {
        $this->system = $request;
        $this->response = $response;
    }

    /**
     * 获取get参数
     *
     * @param null $name
     * @param null $filters 过滤类型 php内置函数filter_list
     * @param null $defaultValue 默认参数
     * @param bool $notAllowEmpty 不能为空
     * @param bool $noRecursive 必须传参
     * @return mixed|null
     * @throws NoRecursiveException
     * @author 明月有色 <2206582181@qq.com>
     */
    public function get($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        if (!isset($this->system->get[$name])) {
            if (!$name) {
                return $this->system->get;
            } elseif ($noRecursive == true) {
                throw new NoRecursiveException($name . ':不能缺少');
            }
            return $defaultValue;
        } elseif (!$this->system->get[$name]) {
            if ($notAllowEmpty == true) {
                throw new NoRecursiveException($name . ':不能为空 ');
            }
            return $defaultValue;
        }
        $value = $this->system->get[$name];
        if ($filters) {
            $value = filter_var($value, $this->getFilterId($filters));
        }
        return $value;
    }

    /**
     * 获取post参数
     *
     * @param null $name
     * @param null $filters 过滤类型 php内置函数filter_list
     * @param null $defaultValue 默认参数
     * @param bool $notAllowEmpty 不能为空
     * @param bool $noRecursive 必须传参
     * @return mixed|null
     * @throws NoRecursiveException
     * @author 明月有色 <2206582181@qq.com>
     */
    public function post($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        if (!isset($this->system->post[$name])) {
            if ($noRecursive == true) {
                throw new NoRecursiveException($name . ':不能缺少');
            }
            return $defaultValue;
        } elseif (!$this->system->post[$name]) {
            if ($notAllowEmpty == true) {
                throw new NoRecursiveException($name . ':不能为空 ');
            }
            return $defaultValue;
        }
        $value = $this->system->post[$name];
        if ($filters) {
            $value = filter_var($value, $this->getFilterId($filters));
        }
        return $value;
    }

    /**
     * 重定向请求，中间件可用
     *
     * @param $uri
     * @param null $method
     * @author 明月有色 <2206582181@qq.com>
     */
    public function setUri($uri, $method = null)
    {
        if ($method) {
            $this->system->server['request_method'] = $method;
        }
        $this->system->server['request_uri'] = $uri;
    }

    /**
     * 获取请求路由
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getUri()
    {
        return $this->system->server['request_uri'];
    }

    /**
     * 获取请求类型
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getMethod()
    {
        return $this->system->server['request_method'];
    }

    /**
     * 获取过滤函数id
     *
     * @param $filters
     * @return mixed
     * @throws \Exception
     * @author 明月有色 <2206582181@qq.com>
     */
    private function getFilterId($filters)
    {
        if (!isset($this->filters[$filters])) {
            throw new \Exception('过滤函数使用错误,filter_list函数查看');
        }
        return $this->filters[$filters];
    }

    /**
     * 获取当前请求对象
     *
     * @return bool|string
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getSession()
    {
        if( $this->session===false ){
            $session_name = "SWOOLE_SESSION";
            $session_path = storage_path('/framework/sessions');
            $session_minutes = 3600;

            if( isset($this->system->cookie[$session_name]) ){
                $handler = new FileSessionHandler(new Filesystem(),$session_path,$session_minutes);
                $sessionStore = new Store($session_name,$handler,$this->system->cookie[$session_name]);
            }else{
                $handler = new FileSessionHandler(new Filesystem(),$session_path,$session_minutes);
                $sessionStore = new Store($session_name,$handler);
                $this->response->cookie($session_name,$sessionStore->getId());
            }

            $this->session = $sessionStore;
            $this->session->start();
        }
        return $this->session;
    }
}