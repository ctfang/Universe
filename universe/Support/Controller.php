<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/23
 * Time: 15:15
 */

namespace Universe\Support;

use Universe\App;
use Universe\Servers\RequestServer;
use Universe\Servers\ResponseServer;

abstract class Controller
{
    /**
     * @var RequestServer
     */
    protected $request;

    /**
     * @var ResponseServer
     */
    protected $response;

    public function __construct(RequestServer &$request, ResponseServer &$response)
    {
        $this->request  = $request;
        $this->response = $response;
    }

    /**
     * 重定向
     *
     * @param $url
     * @return bool
     * @author 明月有色 <2206582181@qq.com>
     */
    public function redirect($url)
    {
        $this->response->header("Location",$url);
        $this->response->status(302);
        $this->response->end('');
        return true;
    }

    /**
     * 获取视图对象
     *
     * @param $file
     * @return mixed
     * @author 明月有色 <2206582181@qq.com>
     */
    public function view($file)
    {
        return App::get('view')->make($file);
    }
}