<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:44
 */

namespace Universe\Servers;


use Swoole\Http\Request;
use Universe\Exceptions\NoRecursiveException;

class RequestServer extends Request
{
    private $filters;
    private $system;

    /**
     * 初始化，对命令行和fpm模式下兼容运行
     *
     * @param null $request
     */
    public function set($request = null)
    {
        $this->system = $request;
        foreach (filter_list() as $value){
            $this->filters[$value] = filter_id($value);
        }
        if ($request == null) {
            $this->get  = $_GET;
            $this->post = $_POST;
            foreach ($_SERVER as $key => $value) {
                $this->server[strtolower($key)] = $value;
            }
        } else {
            $this->get    = $request->get;
            $this->post   = $request->get;
            $this->server = $request->server;
        }
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
        if( !isset($this->get[$name]) ){
            if( !$name ){
                return $this->get;
            }elseif( $noRecursive==true ){
                throw new NoRecursiveException($name.':不能缺少');
            }
            return $defaultValue;
        }elseif ( !$this->get[$name] ){
            if( $notAllowEmpty==true ){
                throw new NoRecursiveException($name.':不能为空 ');
            }
            return $defaultValue;
        }
        $value = $this->get[$name];
        if( $filters ){
            $value = filter_var($value,$this->getFilterId($filters));
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
        if( !isset($this->post[$name]) ){
            if( $noRecursive==true ){
                throw new NoRecursiveException($name.':不能缺少');
            }
            return $defaultValue;
        }elseif ( !$this->post[$name] ){
            if( $notAllowEmpty==true ){
                throw new NoRecursiveException($name.':不能为空 ');
            }
            return $defaultValue;
        }
        $value = $this->post[$name];
        if( $filters ){
            $value = filter_var($value,$this->getFilterId($filters));
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
            $this->server['request_method'] = $method;
        }
        $this->server['request_uri'] = $uri;
    }

    /**
     * 获取请求路由
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getUri()
    {
        return $this->server['request_uri'];
    }

    /**
     * 获取请求类型
     *
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getMethod()
    {
        return $this->server['request_method'];
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
        if( !isset($this->filters[$filters]) ){
            throw new \Exception('过滤函数使用错误,filter_list函数查看');
        }
        return $this->filters[$filters];
    }
}