<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/23
 * Time: 15:15
 */

namespace Universe\Support;

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

    public function redirect($url)
    {
        $this->response->header("Location",$url);
        $this->response->status(302);
        $this->response->end('');
        return true;
    }
}