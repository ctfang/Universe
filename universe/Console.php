<?php
/**
 * Created by PhpStorm.
 * User: baichou
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


        $pathList = [
            $this->app::getPath('/app/Console/Commands'),
        ];

        $namespace = "App\\";


        foreach ($pathList as $path){
            foreach ((new Finder)->in($path)->files() as $command) {
                $command = $namespace.str_replace(
                        ['/', '.php'],
                        ['\\', ''],
                        Str::after($command->getPathname(), $this->app::getPath('/app').DIRECTORY_SEPARATOR)
                    );
                if (is_subclass_of($command, Command::class)){
                    $this->add(new $command);
                }
            }
        }
    }
}