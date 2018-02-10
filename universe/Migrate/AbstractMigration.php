<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/2/10
 * Time: 12:59
 */

namespace Universe\Migrate;


use Phinx\Db\Adapter\AdapterFactory;
use Universe\App;

class AbstractMigration extends \Phinx\Migration\AbstractMigration
{
    public function getAdapter()
    {
        if (isset($this->adapter)) {
            return $this->adapter;
        }

        $options = $this->getDbConfig();

        $adapter = AdapterFactory::instance()->getAdapter($options['adapter'], $options);

        if ($adapter->hasOption('table_prefix') || $adapter->hasOption('table_suffix')) {
            $adapter = AdapterFactory::instance()->getWrapper('prefix', $adapter);
        }

        $this->adapter = $adapter;

        return $adapter;
    }

    /**
     * 获取数据库配置
     * @return array
     */
    protected function getDbConfig()
    {
        $config = App::get('config')->get('database');
        $default = $config['default'];

        $config = $config['connections'][$default];
        $dbConfig = [
            'adapter'      => $config['driver'],
            'host'         => $config['host'],
            'name'         => $config['database'],
            'user'         => $config['username'],
            'pass'         => $config['password'],
            'port'         => $config['port'],
            'charset'      => $config['charset'],
            'table_prefix' => $config['prefix'],
        ];

        return $dbConfig;
    }
}