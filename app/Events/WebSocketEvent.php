<?php
namespace App\Events;

use Universe\App;
use Universe\Events\WebSocketEvent as Event;
use App\Models\User;
use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;

class WebSocketEvent extends Event
{
    /**
     * WebSocketServer 事件，【函数名】=》【对应事件】
     *
     * 'onStart'=>'Start',
     * 'onManagerStart'=>'ManagerStart',
     * 'onWorkerStart'=>'WorkerStart',
     * 'onOpen'=>'Open',
     * 'onMessage'=>'Message',
     * 'onClose'=>'Close',
     */

}