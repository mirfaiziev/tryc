<?php

namespace My\Lib;

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
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }

}