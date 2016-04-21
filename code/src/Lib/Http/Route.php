<?php

namespace My\Lib\Http;

class Route
{
    /**
     * @var string $controller
     */
    protected $controller;

    /**
     * @var string $action
     */
    protected $action;

    /**
     * @var string $param
     */
    protected $param;

    /**
     * Route constructor.
     * @param string $controller
     * @param string $action
     * @param string $param
     */
    public function __construct($controller, $action, $param)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->param = $param;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }
}