<?php

namespace My\Lib\Http\UriParser;
use My\Lib\Config;

/**
 * Interface UriParser - we pass uri and method from request and get array of routes
 * @package My\Lib\Http\Router
 */
interface UriParserInterface
{
    public function __construct(Config $config);
    public function setUri($uri);
    public function setMethod($method);
    public function getRoutes();
}