<?php

namespace My\Lib;

use My\Lib\Dispatcher\ControllerNotFoundException;
use My\Lib\Response\AbstractResponse;
use My\Lib\Router\RouterInterface;

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
    }

    public function dispatch()
    {
        $routes = $this->router->getRoutes();

        try {

            if (empty($routes)) {
                throw new ControllerNotFoundException();
            }

            foreach ($routes as $route) {
               if (class_exists($route->getController())) {
                  if (method_exists($route->getController(), $route->getAction())) {
                      /**
                       * @var AbstractController $controller
                       */
                      $controller = new $route->getController($this->response);
                      
                      call_user_func([$route->getController(), $route->getAction()], $route->getParam());
                      $controller->getResponse()->sendResponse();
                      
                      exit;
                  }
               }
            }

            throw new ControllerNotFoundException();

        } catch (ControllerNotFoundException $e) {

            if (!method_exists($this->errorController, $this->action404)) {
                die('ups'); // todo: add new exception
            }
            /**
             * @var AbstractController $errorController
             */
            $errorController = new $this->errorController($this->response);
            call_user_func([$errorController, $this->action404]);
            $errorController->getResponse()->sendResponse();

            exit;
        }
    }

}