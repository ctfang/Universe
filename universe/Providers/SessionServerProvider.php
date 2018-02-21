<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/12
 * Time: 17:38
 */

namespace Universe\Providers;


use Illuminate\Filesystem\Filesystem;
use Illuminate\Session\FileSessionHandler;
use Illuminate\Session\Store;

class SessionServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'session';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $session_name = "SWOOLE_SESSION";
            $session_path = storage_path('/framework/sessions');
            $session_minutes = 3600;

            $handler = new FileSessionHandler(new Filesystem(),$session_path,$session_minutes);
            $sessionStore = new Store($session_name,$handler);

            return $sessionStore;
        });
    }
}