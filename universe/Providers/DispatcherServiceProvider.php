<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/22
 * Time: 12:31
 */

namespace Universe\Providers;


use Universe\Servers\DispatcherServer;

class DispatcherServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'dispatcher';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new DispatcherServer();
        });
    }
}