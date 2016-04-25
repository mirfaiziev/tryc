<?php

namespace My\Di;

/**
 * Class DI - dependency injection, does not support passing argument to constructor in get method right now
 *
 * @package My\Lib
 */
class DI
{
    /**
     * @var array
     */
    protected $services = [];
    
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
        
        if (is_callable($this->services[$serviceName])) {
            $this->services[$serviceName] = call_user_func($this->services[$serviceName]);
        }
        
        return $this->services[$serviceName];
    }

    public function __call($name, $params)
    {

        // if name doesn't start with get - return null
        if (strncmp('get', $name, 3) !== 0) {
            throw new \Exception('Cannot call function '.__CLASS__.'::'. $name);
        }
        $serviceName = lcfirst(substr($name, 3));

        return $this->get($serviceName);
    }
}