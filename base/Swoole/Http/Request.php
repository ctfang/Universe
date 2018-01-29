<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:44
 */

namespace Universe\Swoole\Http;


class Request extends \Swoole\Http\Request
{
    public function __construct($request = null)
    {
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
     * 重定向请求，中间件可用
     *
     * @param $uri
     * @param null $method
     * @author 明月有色 <2206582181@qq.com>
     */
    public function setUri($uri,$method=null)
    {
        if( $method ){
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
}