<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/10
 * Time: 14:09
 */

use Universe\App;

$config  = App::get('config')->get('database');
$default = $config['default'];
$dbConfig = $config['connections'][$default];

return [
    'paths'                => [
        'migrations' => App::getPath('/database/migrations'),
        'seeds'      => App::getPath('/database/seeds'),
    ],
    'environments'         => [
        'default_migration_table' => $config['migrations'],
        'default_database'        => 'development',
        'development'             => [
            'name'       => $dbConfig['database'],
            'database'   => $dbConfig['database'],
            'connection' => App::get('db')->getConnection()->getPdo()
        ]
    ],
    "migration_base_class" => \Universe\Migrate\AbstractMigration::class,
    "version_order"        => "creation"
];