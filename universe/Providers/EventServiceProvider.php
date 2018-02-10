<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/8
 * Time: 18:43
 */

namespace Universe\Providers;


use Illuminate\Events\Dispatcher;

class EventServiceProvider extends AbstractServiceProvider
{
    protected $serviceName = 'events';

    public function register()
    {
        $listen =$this->listen;
        $this->di->set($this->serviceName, function () use($listen){
            $Dispatcher = new Dispatcher();
            foreach ($listen as $event => $listeners) {
                foreach ($listeners as $listener) {
                    $Dispatcher->listen($event, $listener);
                }
            }
            return $Dispatcher;
        });
    }
}