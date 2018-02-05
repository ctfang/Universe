<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/5
 * Time: 17:05
 */

namespace App\Events;

use \Universe\Events\HttpEvent as Event;

class HttpEvent extends Event
{
    /**
     * httpServer 事件，【函数名】=》【对应事件】
     *
     * 'onRequest'=>'Request',
     * 'onStart'=>'Start',
     * 'onShutdown'=>'Shutdown',
     * 'onWorkerStart'=>'WorkerStart',
     * 'onWorkerStop'=>'WorkerStop',
     * 'onConnect'=>'Connect',
     * 'onClose'=>'Close',
     * 'onTask'=>'Task',
     * 'onFinish'=>'Finish',
     */
}