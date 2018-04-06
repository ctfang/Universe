<?php
/**
 * Created by PhpStorm.
 * User: caojiabin
 * Date: 2018/4/6
 * Time: 19:00
 */

namespace App\Http\Controllers;

use Swoole\WebSocket\Server;
use Swoole\WebSocket\Frame;
use App\Models\User;
use App\Events\WebSocketEvent as Event;

class WebSocketTestController
{

    public function onMessage(Server $server, Frame $frame)
    {
        \Log::info("receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}");
        $user = new User();
        foreach($server->connections as $fd)
        {
            $server->push($fd, "这是广播123");
        }
        $server->push($frame->fd, "this is server".$user->password('13'));
    }

    public function onClose(Server $server, int $fd)
    {
        \Log::info($fd.'closed');
    }

}
