<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/5
 * Time: 14:19
 */

namespace App\Exceptions\Handlers;


use Universe\Exceptions\Handlers\Handler;
use Universe\Exceptions\NotFoundException;

class NotFoundHandler extends Handler
{
    /**
     * 异常处理
     *
     * 404路由处理，当前的dump打印在命令行
     *
     * @return bool false 终止
     */
    public function handle()
    {
        if( $this->exception instanceof NotFoundException){
            $this->response->header('Status Code','404');
            $this->response->header('Content-Type','text/html; charset=UTF-8');
            $this->response->end('路由不存在，请设置路由');

            // 404 不需要特别处理，下面handler不执行
            return false;
        }
    }
}