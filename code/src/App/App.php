<?php

namespace My\App;

use My\Lib\Config;
use My\Lib\Request;

/**
 * Class App -
 * @package My\App
 */
class App
{
    /**
     * @var App $instance
     */
    private static $instance;

    /**
     * @var \My\Lib\Request $request
     */
    protected $request;

    /**
     * @var \My\Lib\Config $config
     */
    protected $config;
    
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param array $configuration
     */
    public function initConfig(array $configuration)
    {
        $this->config = new Config($configuration);
    }

    public function run()
    {
       throw new \Exception('not implemented yet');
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    
    protected function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->initRequest();
    }
    

    protected function initRequest()
    {
        $this->request = new Request();
    }
    
}