<?php

namespace My\Lib;

/**
 * Class Config
 * @package My\Lib
 * @method getErrorModule
 * @method getErrorController
 * @method getAction400
 * @method getAction404
 * @method getAction500
 */
class Config
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Config constructor.
     * @param array|null $config
     */
    public function __construct(array $config = null)
    {
        $this->config = $config;
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed|null
     */
    public function __call($method, $arguments)
    {
        // if name doesn't start with get - return null
        if (strncmp('get', $method, 3) !== 0) {
            return null;
        }

        $configName = lcfirst(substr($method, 3));
        return $this->get($configName);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }

}