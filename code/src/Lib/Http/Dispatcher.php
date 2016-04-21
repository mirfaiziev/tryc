<?php

namespace My\Lib\Http;

use My\Lib\Http\Dispatcher\ControllerNotFoundException;
use My\Lib\Http\Dispatcher\In;
use My\Lib\Http\Dispatcher\InternalServerErrorException;
use My\Lib\Http\Response\AbstractResponse;
use My\Lib\Http\Router\RouterInterface;

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
     * @var AbstractResponse
     */
    protected $response;

    /**
     * @var string
     */
    protected $errorController;

    /**
     * @var string
     */
    protected $action404;

    /**
     * Dispatcher constructor.
     * @param Config $config
     * @param RouterInterface $router
     * @param AbstractResponse $response
     */
    public function __construct(Config $config, RouterInterface $router, AbstractResponse $response)
    {
        $this->config = $config;
        $this->router = $router;
        $this->response = $response;

        $this->errorController = $this->config->getErrorController();
        $this->action404 = $this->config->getAction404();
        $this->action500 = $this->config->getAction500();
    }

    public function dispatch()
    {
        $routes = $this->router->getRoutes();

            if (empty($routes)) {
                throw new ControllerNotFoundException();
            }

            foreach ($routes as $route) {
               if (class_exists($route->getController())) {
                  if (method_exists($route->getController(), $route->getAction())) {
                      $controllerName = $route->getController();
                      /**
                       * @var AbstractController $controller
                       */
                      $controller = new $controllerName($this->response);
                      
                      call_user_func([$controller, $route->getAction()], $route->getParam());
                      $controller->getResponse()->sendResponse();
                      
                      exit;
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
        /**
         * @var AbstractController $errorController
         */
        $errorController = new $this->errorController($this->response);
        call_user_func([$errorController, $this->action404], $this->errorController, $this->action404);
        $errorController->getResponse()->sendResponse();

        exit;
    }

    /**
     * @param string $message
     */
    public function handlerRuntimeException($message)
    {
        if (!method_exists($this->errorController, $this->action500)) {
            http_response_code(AbstractResponse::CODE_ERROR);
            echo 'Ups... Something went wrong. '.$message;
            exit;
        }

        /**
         * @var AbstractController $errorController
         */
        $errorController = new $this->errorController($this->response);
        call_user_func([$errorController, $this->action500], $message);
        $errorController->getResponse()->sendResponse();

        exit;
    }

}