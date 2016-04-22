<?php

namespace My\Lib\Http;

use My\Lib\Http\Dispatcher\ControllerNotFoundException;
use My\Lib\Http\Dispatcher\InternalServerErrorException;
use My\Lib\Http\Response\AbstractResponse;
use My\Lib\Http\Router\RouterInterface;
use My\Lib\Http\Controller\AbstractController;

/**
 * Class Dispatcher. It return result of execution controller or errors
 * 400 - if some runtime error, f.e. validation error
 * 404 - if controller not found
 * 500 - if internal server error, f.e. file not found
 * @package My\Lib\Http
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
     * @param AbstractResponse $response
     */
    public function __construct(Config $config, RouterInterface $router, AbstractResponse $response)
    {
        $this->config = $config;
        $this->router = $router;
        $this->response = $response;

        $this->errorController = $this->config->getErrorController();

        $this->action400 = $this->config->getAction400();
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
                  $this->execute($route->getController(), $route->getAction(), $route->getParam());
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

        $this->execute($this->errorController, $this->action404);
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

        $this->execute($this->errorController, $this->action500, $message);
    }

    /**
     * @param $message
     */
    public function handlerRuntimeException($message)
    {
        if (!method_exists($this->errorController, $this->action400)) {
            throw new InternalServerErrorException('Cannot find action for handling 400 error');
        }

        $this->execute($this->errorController, $this->action400, $message);
    }

    /**
     * @param string $controllerName
     * @param string $action
     * @param array $params
     */
    protected function execute($controllerName, $action, ...$params)
    {
        /**
         * @var AbstractController $controller
         */
        $controller = new $controllerName($this->config, $this->response);
        call_user_func([$controller, $action], ...$params);
        $controller->getResponse()->sendResponse();

        exit;
    }
}