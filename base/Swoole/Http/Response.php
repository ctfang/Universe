<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 18:43
 */

namespace Universe\Swoole\Http;


class Response extends \Swoole\Http\Response
{
    /**
     * @var \Swoole\Http\Response
     */
    protected $system;

    public function __construct($response = null)
    {
        $this->system = $response;
    }

    /**
     * @param string $html
     * @author 明月有色 <2206582181@qq.com>
     */
    public function end($html = '')
    {
        if( is_debug() && ob_get_status() ){
            // 捕捉页面的输出
            $contents = ob_get_contents();
            if( $contents ){
                $html .= $contents;
            }
            ob_end_clean();
        }

        if (PHP_RUN_TYPE === 'php-fpm') {
            echo $html;
        } else {
            $this->system->end($html);
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
            $this->system->header($key, $value, $ucwords);
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
        $this->system->cookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }
}