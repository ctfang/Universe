<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/26
 * Time: 20:00
 */

namespace Universe\Providers;

use App\Exceptions\Kernel;
use Universe\App;
use Universe\Util\SystemFacade;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

class ExceptionServerProvider extends AbstractServiceProvider
{
    protected $serviceName = 'exception';

    public function register()
    {
        $this->di->set($this->serviceName,function (){
            $run = new Run( new SystemFacade() );

            (new Kernel($run))->register();

            // 所有错误日记记录
            $PlainTextHandler = new PlainTextHandler();
            $PlainTextHandler->setLogger(App::get('logger'));
            $PlainTextHandler->loggerOnly(true);
            $run->pushHandler($PlainTextHandler);
            return $run;
        });
    }
}