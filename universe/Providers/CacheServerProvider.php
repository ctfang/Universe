<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/11
 * Time: 16:27
 */

namespace Universe\Providers;


use Symfony\Component\Cache\Simple\FilesystemCache;


class CacheServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'cache';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $cache = new FilesystemCache();

            return $cache;
        });
    }
}