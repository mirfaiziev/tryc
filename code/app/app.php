<?php

namespace App;

use My\Di\DI;
use My\Config\Config;
use My\HttpFramework\Dispatcher\ControllerNotFoundException;
use My\HttpFramework\Dispatcher\ControllerRuntimeException;
use My\HttpFramework\Dispatcher\InternalServerErrorException;

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

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param array $configuration
     * @throws \Exception
     */
    public function init(array $configuration)
    {
        if (!isset($configuration['autoload'])) {
            throw new \Exception('Wrong configuration, cannot find autoload section');
        }

        $this->initAutoLoaders($configuration['autoload']);

        $this->di = new DI();

        $this->di->set('config', function () use ($configuration) {
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

    protected function initAutoLoaders(array $autoLoadersConfiguration)
    {
        require_once __DIR__ . '/autoload.php';

        $autoLoader = new Autoload();

        foreach ($autoLoadersConfiguration as $item) {
            $autoLoader->addClassMap($item['prefix'], $item['baseDir']);
        }

        $autoLoader->register();
    }
}