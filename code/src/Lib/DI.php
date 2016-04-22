<?php

namespace My\Lib;

/**
 * Class DI - dependency injection
 * @package My\Lib
 */
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
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public function get($serviceName, ...$params)
    {
        if (!isset($this->services[$serviceName])) {
            throw new \Exception('Cannot find service '. $serviceName);
        }

        $serializedParams = serialize($params);

        if (!isset($this->results[$serviceName][$serializedParams])) {
            $this->results[$serviceName][$serializedParams] = call_user_func($this->services[$serviceName], ...$params);
        }
        return $this->results[$serviceName][$serializedParams];
    }

    public function __call($name, $params)
    {

        // if name doesn't start with get - return null
        if (strncmp('get', $name, 3) !== 0) {
            throw new \Exception('Cannot call function '.__CLASS__.'::'. $name);
        }
        $serviceName = lcfirst(substr($name, 3));

        return $this->get($serviceName, ...$params);
    }
}