<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 16:36
 */

namespace Universe\Providers;


use Universe\Servers\OutputServer;

class ExportServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'output';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new OutputServer();
        });
    }
}