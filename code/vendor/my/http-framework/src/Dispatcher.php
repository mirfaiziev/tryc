<?php

namespace My\HttpFramework;

use My\HttpFramework\Dispatcher\ControllerNotFoundException;
use My\HttpFramework\Dispatcher\InternalServerErrorException;
use My\HttpFramework\Response\AbstractResponse;
use My\HttpFramework\Router\RouterInterface;
use My\Config\Config;

/**
 * Class Dispatcher. It return result of execution controller or errors
 * 400 - if some runtime error, f.e. validation error
 * 404 - if controller not found
 * 500 - if internal server error, f.e. file not found
 * @package My\HttpFramework
 */

class Dispatcher
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var AbstractResponse
     */
    protected $response;

    /**
     * @var string
     */
    protected $errorModule;

    /**
     * @var string
     */
    protected $errorController;

    /**
     * @var string
     */
    protected $action400;

    /**
     * @var string
     */
    protected $action404;

    /**
     * @var string
     */
    protected $action500;


    /**
     * Dispatcher constructor.
     * @param Config $config
     * @param RouterInterface $router
     * @param Request $request
     * @param AbstractResponse $response
     */
    public function __construct(Config $config, RouterInterface $router, Request $request, AbstractResponse $response)
    {
        $this->router = $router;
        $this->request = $request;
        $this->response = $response;

        $this->errorModule = $config->getErrorModule();
        $this->errorController = $config->getErrorController();

        $this->action400 = $config->getAction400();
        $this->action404 = $config->getAction404();
        $this->action500 = $config->getAction500();
    }

    public function dispatch()
    {
        $routes = $this->router->getRoutes();

        if (empty($routes)) {
            throw new ControllerNotFoundException();
        }

        /**
         * @var Route $route
         */
        foreach ($routes as $route) {
           if (class_exists($route->getController())) {
              if (method_exists($route->getController(), $route->getAction())) {
                  $this->execute($route->getModule(), $route->getController(), $route->getAction(), $route->getParam());
              }
           }
        }

        throw new ControllerNotFoundException();
    }

    /**
     * @throws InternalServerErrorException
     */
    public function handlerControllerNotFound()
    {
        if (!method_exists($this->errorController, $this->action404)) {
            throw new InternalServerErrorException('Cannot find action for handling 404 error');
        }

        $this->execute($this->errorModule, $this->errorController, $this->action404);
    }

    /**
     * @param string $message
     */
    public function handlerInternalServerError($message)
    {
        if (!method_exists($this->errorController, $this->action500)) {
            http_response_code(AbstractResponse::CODE_ERROR);
            echo 'Ups... Something went wrong. '.$message;
            exit;
        }

        $this->execute($this->errorModule, $this->errorController, $this->action500, $message);
    }

    /**
     * @param $message
     */
    public function handlerRuntimeException($message)
    {
        if (!method_exists($this->errorController, $this->action400)) {
            throw new InternalServerErrorException('Cannot find action for handling 400 error');
        }

        $this->execute($this->errorModule, $this->errorController, $this->action400, $message);
    }

    /**
     * @param $moduleNamespace
     * @param string $controllerClass
     * @param string $action
     * @param array $params
     */
    protected function execute($moduleNamespace, $controllerClass, $action, ...$params)
    {
        $this->registerModuleService($moduleNamespace);

        $controller = new $controllerClass($this->request, $this->response);

        // before action
        if (method_exists($controller, 'beforeAction')) {
            call_user_func([$controller, 'beforeAction'], ...$params);
        }
        
        call_user_func([$controller, $action], ...$params);

        // after action
        if (method_exists($controller, 'afterAction')) {
            call_user_func([$controller, 'afterAction'], ...$params);
        }
        
        $controller->getResponse()->sendResponse();

        exit;
    }

    /**
     * @param string $moduleNamespace
     */
    protected function registerModuleService($moduleNamespace)
    {
        $registerServicesClass = $moduleNamespace.'\\RegisterServices';

        if (method_exists($registerServicesClass, 'init')) {
            call_user_func([$registerServicesClass, 'init']);
        }
    }
}