<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:43
 */

namespace Universe\Servers;


use Swoole\Http\Response;

class ResponseServer extends Response
{
    /**
     * @var RequestServer
     */
    protected $request;

    public function set(RequestServer $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $html
     * @author 明月有色 <2206582181@qq.com>
     */
    public function end($html = '')
    {
        if ( is_string($html) ) {
            $this->header('Content-Type', 'text/html; charset=UTF-8');
        }else{
            $this->header('Content-Type', 'application/json; charset=UTF-8');
            $html = json_encode($html, JSON_UNESCAPED_UNICODE);
        }

        $this->request->response->end($html);
    }

    /**
     * @param $key
     * @param $value
     * @param null $ucwords
     * @author 明月有色 <2206582181@qq.com>
     */
    public function header($key, $value, $ucwords = null)
    {
        $this->request->response->header($key, $value, $ucwords);
    }

    /**
     * @param string $name
     * @param null $value
     * @param null $expires
     * @param null $path
     * @param null $domain
     * @param null $secure
     * @param null $httponly
     * @author 明月有色 <2206582181@qq.com>
     */
    public function cookie($name, $value = NULL, $expires = NULL, $path = NULL, $domain = NULL, $secure = NULL, $httponly = NULL)
    {
        $this->request->response->cookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }


    /**
     * 设置HttpCode，如404, 501, 200
     *
     * @param $code
     * @author 明月有色 <2206582181@qq.com>
     */
    public function status($code)
    {
        $this->request->response->status($code);
    }
}