<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:44
 */

namespace Universe\Swoole\Http;


use Universe\Exceptions\NoRecursiveException;

class Request extends \Swoole\Http\Request
{
    private $filters;

    public function __construct($request = null)
    {
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

    public function get($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false)
    {
        if( !isset($this->get[$name]) ){
            if( $noRecursive==true ){
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

    public function getUri()
    {
        return $this->server['request_uri'];
    }

    public function getMethod()
    {
        return $this->server['request_method'];
    }

    private function getFilterId($filters)
    {
        if( !isset($this->filters[$filters]) ){
            throw new \Exception('过滤函数使用错误,filter_list函数查看');
        }
        return $this->filters[$filters];
    }
}