<?php

namespace My\HttpFramework\UriParser;

use My\Config\Config;

/**
 * Interface UriParser - we pass uri and method from request and get array of routes
 * @package My\HttpFramework\Router
 */
interface UriParserInterface
{
    public function __construct(Config $config);
    public function setUri($uri);
    public function setMethod($method);
    public function getRoutes();
}