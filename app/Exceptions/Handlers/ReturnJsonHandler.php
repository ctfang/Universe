<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/3/7
 * Time: 15:13
 */

namespace App\Exceptions\Handlers;


use Universe\Servers\ResponseServer;
use Whoops\Handler\Handler;

class ReturnJsonHandler extends Handler
{
    /**
     * 非调试模式，返回内容
     *
     * @return array
     */
    public function handle()
    {
        $response = $this->getResponse();
        $data     = [
            'code'=>500,
            'msg'=>$this->getException()->getMessage()
        ];
        $response->end($data);
    }

    /**
     * @return ResponseServer
     * @author 明月有色 <2206582181@qq.com>
     */
    private function getResponse()
    {
        return $this->getException()->response;
    }
}