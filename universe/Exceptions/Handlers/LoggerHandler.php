<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 21:03
 */

namespace Universe\Exceptions\Handlers;


use Universe\App;
use Universe\Servers\RequestServer;
use Whoops\Handler\PlainTextHandler;

class LoggerHandler extends PlainTextHandler
{
    /**
     * @return int|null A handler may return nothing, or a Kernel::HANDLE_* constant
     */
    public function handle()
    {
        $response = $this->generateResponse();

        if( $this->getRequest() ){
            App::get('logger')->error("uri:".$this->getRequest()->getUri().PHP_EOL.$response);
        }else{
            // 非界面，没有uri
            App::get('logger')->error($response);
        }
    }


    /**
     * @return RequestServer|bool
     * @author 明月有色 <2206582181@qq.com>
     */
    public function getRequest()
    {
        try{
            return $this->getException()->request;
        }catch (\Error $exception){
            return false;
        }catch (\Exception $exception){
            return false;
        }
    }
}