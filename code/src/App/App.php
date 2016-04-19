<?php

namespace My\App;

use My\Lib\Request;

/**
 * Class App -
 * @package My\App
 */
class App
{
    /**
     * @var $instance App
     */
    private static $instance;

    /**
     * @var $request \My\Lib\Request;
     */
    protected $request;
    
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
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