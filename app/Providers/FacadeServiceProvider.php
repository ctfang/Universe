<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:41
 */

namespace App\Providers;


use Universe\Facades\CacheFacade;
use Universe\Facades\DatabaseFacade;
use Universe\Facades\EventFacade;
use Universe\Facades\LoggerFacade;

class FacadeServiceProvider extends \Universe\Providers\FacadeServiceProvider
{
    /**
     * facade是在服务启动之前注册的
     *
     * 不支持非全局的server使用facade
     * 例如request、response等
     *
     * @var array
     */
    protected $aliases = [
        'DB'=>DatabaseFacade::class,
        'Log'=>LoggerFacade::class,
        'Event'=>EventFacade::class,
        'Cache'=>CacheFacade::class,
        'Config'=>CacheFacade::class,
    ];
}