<?php
/**
 * Created by PhpStorm.
 * User: baichou
 * Date: 2018/1/30
 * Time: 14:44
 */

namespace App\Exceptions\Handlers;


use Universe\Exceptions\Handlers\Handler;

class ShowErrorHandler extends Handler
{
    /**
     * @return bool
     */
    public function handle()
    {
        dump($this->exception);
        dump($this->exception->getTraceAsString());
    }
}