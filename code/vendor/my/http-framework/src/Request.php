<?php

namespace My\HttpFramework;

class Request 
{
    /**
     * @var array
     */
    protected $server;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var string (get|set|put|delete)
     */
    protected $method;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var array
     */
    protected $allowedMethods = ['get', 'post', 'put', 'delete'];

    /**
     * Request constructor.
     * @param array $server
     * @param null $body
     */
    public function __construct(array $server = null, $body = null)
    {
        $this->server = isset($server) ? $server : $_SERVER;
        $this->body = isset($body) ? $body : file_get_contents('php://input');
        $this->init();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
    
    protected function init()
    {
        $this->initMethod();
        $this->initUri();
    }

    protected function initMethod()
    {
        if (!isset($this->server['REQUEST_METHOD'])) {
            throw new \InvalidArgumentException('Cannot define request method');
        }

        $method = strtolower($this->server['REQUEST_METHOD']);

        if (!in_array($method, $this->allowedMethods)) {
            throw new \DomainException('Incorrect method: '.$method);
        }

        $this->method = $method;
    }

    protected function initUri()
    {
        if (!isset($this->server['REQUEST_URI'])) {
            throw new \InvalidArgumentException('Cannot define request uri');
        }
        
        $this->uri = strtolower($this->server['REQUEST_URI']);
    }
}
