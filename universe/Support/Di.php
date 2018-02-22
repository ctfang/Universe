<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/18
 * Time: 20:48
 */

namespace Universe\Support;


class Di
{
    private $di;
    private $servers;

    /**
     * 加入
     *
     * @param $name
     * @param $definition
     */
    public function set($name, $definition)
    {
        $this->di[$name] = $definition;
    }

    /**
     * 移除
     *
     * @param $name
     */
    public function remove($name)
    {
        unset($this->servers[$name]);
    }

    /**
     * 新建
     *
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->di[$name]();
    }

    /**
     * 获取共享的对象
     *
     * @param $name
     * @return mixed
     */
    public function &getShared($name)
    {
        if( !isset($this->servers[$name]) ){
            $this->servers[$name] = $this->di[$name]();
        }
        return $this->servers[$name];
    }

    /**
     * Check whether the DI contains a service by a name
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->servers[$name]);
    }
}