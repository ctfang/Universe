<?php

namespace Universe\Providers;

use Universe\Support\Di;

/**
 * \Apps\Providers\AbstractServiceProvider
 *
 * @package Apps\Providers
 */
abstract class AbstractServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName;

    protected $di;

    public function __construct(Di &$di)
    {
        $this->di = $di;
    }

    abstract public function register();
}
