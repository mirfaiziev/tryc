<?php

namespace My\Lib\UriParser;
use My\Lib\Config;

/**
 * Interface UriParser - we pass uri and method from request and get array of routes
 * @package My\Lib\Router
 */
interface UriParserInterface
{
    public function __construct(Config $config, $uri, $method);
    public function getRoutes();
}