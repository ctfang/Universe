<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 21:00
 */

namespace Universe\Servers;


use Universe\App;

class ConfigServer
{
    private $config = [];
    private $configPath;

    public function __construct()
    {
        $this->configPath = App::getPath('/config/');
        $this->configure('app');
        $this->configure('database','database');
    }

    /**
     * 加载额外的配置文件
     *
     * @param $fileName
     * @param $prefix
     * @author 明月有色 <2206582181@qq.com>
     */
    public function configure($fileName, $prefix = null)
    {
        if ($prefix) {
            $config[$prefix] = include $this->configPath . $fileName . '.php';
            $this->config    = array_merge($this->config, $config);
        } else {
            $config       = include $this->configPath . $fileName . '.php';
            $this->config = array_merge($this->config, $config);
        }
    }

    /**
     * 动态设置值
     *
     * @param $key
     * @param $value
     * @author 明月有色 <2206582181@qq.com>
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * 获取值
     *
     * @param $key
     * @param null $default
     * @return null
     * @author 明月有色 <2206582181@qq.com>
     */
    public function get($key, $default = null)
    {
        if ($key === null) {
            return $this->config;
        } elseif (!strpos($key, '.')) {
            return isset($this->config[$key]) ? $this->config[$key] : $default;
        }
        $arrConfigKey = explode('.', $key);
        if (!isset($this->config[$arrConfigKey[0]])) {
            return $default;
        }
        $config = $this->config[$arrConfigKey[0]];
        unset($arrConfigKey[0]);
        foreach ($arrConfigKey as $num => $keyNext) {
            if (!isset($config[$keyNext])) {
                return $default;
            } else {
                $config = $config[$keyNext];
            }
        }
        return $config;
    }
}