<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/8
 * Time: 18:52
 */

namespace App\Providers;

use Universe\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Database\Events\QueryExecuted' => [
            'App\Listeners\EventListener',
        ],
    ];
}