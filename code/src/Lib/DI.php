<?php

namespace My\Lib;

class DI
{
    /**
     * @var array
     */
    protected $services = [];

    /**
     * @var array
     */
    protected $results = [];

    /**
     * @param $serviceName
     * @param callable $callback
     */
    public function set($serviceName, callable $callback)
    {
        $this->services[$serviceName] = $callback;
    }

    /**
     * @param $serviceName
     * @return mixed
     * @throws \Exception
     */
    public function get($serviceName)
    {
        if (!isset($this->services[$serviceName])) {
            throw new \Exception('Cannot find service '. $serviceName);
        }

        if (!isset($this->results[$serviceName])) {
            $this->results[$serviceName] = call_user_func($this->services[$serviceName]);
        }
        return $this->results[$serviceName];
    }

    public function __call($name, $arguments)
    {
        // if name doesn't start with get - return null
        if (strncmp('get', $name, 3) !== 0) {
            return null;
        }

        $serviceName = lcfirst(substr($name, 3));
        return $this->get($serviceName);
    }
}