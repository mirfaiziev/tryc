<?php

namespace My\App;

use My\Lib\DI;
use My\Lib\Config;
use My\Lib\Http\Dispatcher;

use My\Lib\Http\Dispatcher\ControllerNotFoundException;
use My\Lib\Http\Dispatcher\ControllerRuntimeException;
use My\Lib\Http\Dispatcher\InternalServerErrorException;

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
     * @var DI;
     */
    protected $di;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;
    
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
    public function init(array $configuration)
    {
        $this->di = new DI();
        $this->di->set('config', function() use ($configuration) {
            return new Config($configuration);
        });
        
        RegisterServices::init();
    }

    public function run()
    {
        $dispatcher = $this->di->get('app::dispatcher');

        try {
            $dispatcher->dispatch();
        } catch (ControllerRuntimeException $e) {
            $dispatcher->handlerRuntimeException($e->getMessage());
        } catch (ControllerNotFoundException $e) {
            try {
                $dispatcher->handlerControllerNotFound();

            } catch (InternalServerErrorException $e) {
                $dispatcher->handlerInternalServerError($e->getMessage());
            }
        } catch (InternalServerErrorException $e) {
            $dispatcher->handlerInternalServerError($e->getMessage());
        } catch (\Exception $e) {
            $dispatcher->handlerInternalServerError($e->getMessage());
        }
    }
    
    /**
     * @return DI
     */
    public function getDi()
    {
        return $this->di;
    }

    protected function __construct()
    {
    }
}