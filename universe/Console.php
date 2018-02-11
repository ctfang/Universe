<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/9
 * Time: 10:54
 */

namespace Universe;

use Illuminate\Support\Str;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

class Console extends Application
{
    /**
     * @var App
     */
    public $app ;

    public function __construct($app)
    {
        parent::__construct('Universe', '1.0');

        $this->app = $app;

        $namespace = "App\\";

        foreach ((new Finder)->in($this->app::getPath('/app/Console/Commands'))->files() as $command) {
            $command = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), $this->app::getPath('/app').DIRECTORY_SEPARATOR)
                );
            if (is_subclass_of($command, Command::class)){
                $this->add(new $command);
            }
        }

        $namespace = "Universe\\";

        foreach ((new Finder)->in(__DIR__.'/Console/Commands')->files() as $command) {
            $command = $namespace.str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), $this->app::getPath('/universe').DIRECTORY_SEPARATOR)
                );
            if (is_subclass_of($command, Command::class)){
                $this->add(new $command);
            }
        }
    }
}