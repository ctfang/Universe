<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/11/24
 * Time: 14:56
 */

namespace Universe\Providers;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Universe\App;

/**
 * Class LoggerServiceProvider
 * @package Framework\Providers
 */
class LoggerServiceProvider extends AbstractServiceProvider
{
    public $serviceName = 'logger';


    /**
     * Register application service.
     *
     * @return mixed
     */
    public function register()
    {
        $this->di->set($this->serviceName, function () {
            // log级别，按顺序
            $levels = array(
                'debug'     => Logger::DEBUG,
                'info'      => Logger::INFO,
                'notice'    => Logger::NOTICE,
                'warning'   => Logger::WARNING,
                'error'     => Logger::ERROR,
                'critical'  => Logger::CRITICAL,
                'alert'     => Logger::ALERT,
                'emergency' => Logger::EMERGENCY,
            );

            $config   = App::get('config');
            $logger   = new Logger($config->get('env','test'));
            $filename = App::getPath() . '/storage/logs/universe.log';
            // 最小处理handler
            $log_level     = $levels[$config->get('log_level','debug')];
            $StreamHandler = new RotatingFileHandler($filename, $config->get('log_max_files','30'), $log_level);
            $StreamHandler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %context%\n", null, true));
            $logger->pushHandler($StreamHandler);

            return $logger;
        });
    }
}