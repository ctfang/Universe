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
        $this->response->end($this->exception->getTraceAsString());
    }
}