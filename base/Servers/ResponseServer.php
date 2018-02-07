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
     * @var Response
     */
    protected $server;

    public function set($response = null)
    {
        $this->server = $response;
    }

    /**
     * @param string $html
     * @author 明月有色 <2206582181@qq.com>
     */
    public function end($html = '')
    {
        if(is_array($html)){
            $this->header('Content-Type','application/json');
            $html = json_encode($html,JSON_UNESCAPED_UNICODE);
        }elseif ( is_object($html) ){
            $this->header('Content-Type','application/json');
            $html = json_encode($html,JSON_UNESCAPED_UNICODE);
        }elseif($html!==null){
            $this->header('Content-Type','text/html; charset=UTF-8');
        }

        if( is_debug() && ob_get_status() ){
            $contents = ob_get_contents();
            if( $contents ){
                $html .= $contents;
            }
            ob_end_clean();
        }

        if (PHP_RUN_TYPE === 'php-fpm') {
            echo $html;
        } else {
            $this->server->end($html);
        }
    }

    /**
     * @param $key
     * @param $value
     * @param null $ucwords
     * @author 明月有色 <2206582181@qq.com>
     */
    public function header($key, $value, $ucwords = null)
    {
        if (PHP_RUN_TYPE === 'php-fpm') {
            //header($key.': '.$value);
        } else {
            $this->server->header($key, $value, $ucwords);
        }
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
        $this->server->cookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }
}