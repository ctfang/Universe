#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 18:03
 */

define('PHP_RUN_TYPE','swoole');

require __DIR__.'/bootstrap/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$console = new \Universe\Console($app);

$console->run();
