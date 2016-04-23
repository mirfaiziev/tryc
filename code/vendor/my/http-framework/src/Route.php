<?php

namespace My\HttpFramework;

class Route
{
    /**
     * @var string module
     */
    protected $module;
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
     * @param string $module
     * @param string $controller
     * @param string $action
     * @param string $param
     */
    public function __construct($module, $controller, $action, $param)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;
        $this->param = $param;
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
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