<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 14:19
 */

namespace App\Exceptions\Handlers;

use Universe\App;
use Universe\Exceptions\NotFoundException;
use Whoops\Handler\Handler;

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
        if( $this->getException() instanceof NotFoundException){
            $response = App::getShared('response');
            $response->status('404');
            $response->end('路由不存在，请设置路由');

            // 404 不需要特别处理，下面handler不执行
            return Handler::QUIT;
        }
    }
}