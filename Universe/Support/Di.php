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

    public function set($name, $definition)
    {
        $this->di[$name] = $definition;
    }

    public function remove($name)
    {
        unset($this->di[$name]);
    }

    public function get($name)
    {
        if( $this->di[$name] instanceof \Closure){
            $this->di[$name] = $this->di[$name]();
        }
        return $this->di[$name];
    }

    public function &getShared($name)
    {
        if( $this->di[$name] instanceof \Closure){
            $this->di[$name] = $this->di[$name]();
        }
        return $this->di[$name];
    }

    /**
     * Check whether the DI contains a service by a name
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->di[$name]);
    }
}