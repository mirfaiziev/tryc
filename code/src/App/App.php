<?php

namespace My\App;

use My\Lib\Http\Config;
use My\Lib\Http\Dispatcher;
use My\Lib\Http\Request;
use My\Lib\Http\Response\AbstractResponse;
use My\Lib\Http\Response\JsonResponse;
use My\Lib\Http\Router\DefaultRouter;
use My\Lib\Http\Router\RouterInterface;
use My\Lib\Http\UriParser\DefaultUriParser;
use My\Lib\Http\UriParser\UriParserInterface;
use My\Lib\Http\Dispatcher\ControllerNotFoundException;
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
     * @var Request $request
     */
    protected $request;

    /**
     * @var AbstractResponse
     */
    protected $response;

    /**
     * @var Config $config
     */
    protected $config;

    /**
     * @var UriParserInterface
     */
    protected $uriParser;

    /**
     * @var RouterInterface
     */
    protected $router;

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

    public function run()
    {
        try {
            $this->dispatcher->dispatch();
        } catch (\RuntimeException $e) {
            // todo 2 types of exception - file not found or not valid data
        } catch (ControllerNotFoundException $e) {
            try {
                $this->dispatcher->handlerControllerNotFound();

            } catch (\RuntimeException $e) {
                $this->dispatcher->handlerInternalServerError($e->getMessage());
            }
        } catch (\RuntimeException $e) {
            $this->dispatcher->handlerInternalServerError($e->getMessage());
        }
    }

    /**
     * @param array $configuration
     */
    public function init(array $configuration)
    {
        $this->config = new Config($configuration);
        $this->initRequest();
        $this->initResponse();
        $this->initUriParser();
        $this->initRouter();
        $this->initDispatcher();
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
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
    }

    protected function initRequest()
    {
        $this->request = new Request();
    }
    
    protected function initResponse()
    {
        $this->response = new JsonResponse();
    }
    
    protected function initUriParser()
    {
        $this->uriParser = new DefaultUriParser($this->config);
    }

    protected function initRouter()
    {
        $this->router = new DefaultRouter($this->request, $this->uriParser);
    }

    protected function initDispatcher()
    {
        $this->dispatcher = new Dispatcher($this->config, $this->router, $this->response);
    }
    
}