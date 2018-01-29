<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/29
 * Time: 16:36
 */

namespace Universe\Providers;


use Universe\Servers\ExportServer;

class ExportServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'export';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            return new ExportServer();
        });
    }
}