<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/8
 * Time: 19:07
 */

namespace App\Listeners;


use Illuminate\Database\Events\QueryExecuted;
use Monolog\Logger;
use Universe\App;

class EventListener
{
    /**
     * @var Logger
     */
    protected $logger;

    public function __construct()
    {
        $this->logger = App::get('logger');
    }

    public function handle(QueryExecuted $event)
    {
        $this->logger->info($event->connectionName.' ['.$event->sql.']',$event->bindings);
    }
}