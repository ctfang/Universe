<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/2/10
 * Time: 17:41
 */

namespace App\Providers;


use Universe\Facades\DatabaseFacade;
use Universe\Facades\LoggerFacade;

class FacadeServiceProvider extends \Universe\Providers\FacadeServiceProvider
{
    /**
     * @var array
     */
    protected $aliases = [
        'DB'=>DatabaseFacade::class,
        'Log'=>LoggerFacade::class
    ];
}