<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/5
 * Time: 18:36
 */

namespace App\Exceptions\Handlers;


use Whoops\Handler\PrettyPageHandler;

class GetPrettyPageHandler extends PrettyPageHandler
{
    public function handle()
    {
        ob_start();
        $this->handleUnconditionally(true);
        $return = parent::handle();

        $html = ob_get_clean();

        // html 是错误页面，可以用来发送邮件

        return $return;
    }
}