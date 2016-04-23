<?php

namespace My\HttpFramework\UriParser;

use My\HttpFramework;
use My\Config\Config;
use My\HttpFramework\Route;
/**
 * Class DefaultUriParser - default implementation of Uri Parser, it means we don't expect any custom routes (but we can have it)
 * just define controller and method from uri like following:
 *
 * /aaa/bbb - will return 2 possible routes:
 *  1) controller aaa, method bbb, param = null
 *  2) controller aaa, param bbb
 *
 *
 * @package My\HttpFramework\UriParser
 */
class DefaultUriParser implements UriParserInterface
{
    const MODULES_DIRECTORY = 'Module';
    const CONTROLLERS_DIRECTORY = 'Controller';
    const ACTION_SUFFIX = 'Action';
    const CONTROLLER_SUFFIX = 'Controller';
    const NAMESPACE_PREFIX = '\\My\\';

    const MODULE_NAMESPACE = self::NAMESPACE_PREFIX.self::MODULES_DIRECTORY.'\%s';

    const CONTROLLER_NAMESPACE = self::MODULE_NAMESPACE.'\\'.self::CONTROLLERS_DIRECTORY.'\\%s'.self::CONTROLLER_SUFFIX;

    /**
     * @var string $uri
     */
    protected $uri;

    /**
     * @var string $action;
     */
    protected $action;

    /**
     * @var string $defaultController
     */
    protected $defaultController;

    /**
     * @var string $defaultModule
     */
    protected $defaultModule;

    /**
     * UriParser constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->defaultController = $config->getDefaultController();
        $this->defaultModule = $config->getDefaultModule();
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->action = $method.self::ACTION_SUFFIX;
    }

    /**
     * @return array<Route>
     * @throws UriParserException
     */
    public function getRoutes()
    {
        $chunks =  explode('/', ltrim($this->uri, '/'));

        switch (count($chunks)) {
            case 1:
                if (empty($chunks[0])) {
                   return $this->getDefaultRoute();
                } else {
                    return $this->getRoutesByOneChunk($chunks[0]);
                }
            case 2:
                return $this->getRoutesByTwoChunks($chunks);
            case 3:
                return $this->getRoutesByThreeChunks($chunks);
            default:
                throw new UriParserException('Cannot parse uri: '.$this->uri);
                break;
        }
    }

    /**
     * @return array<Routes>
     */
    protected function getDefaultRoute()
    {
        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $this->defaultModule);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE,$this->defaultModule , $this->defaultController);
        return array(new Route($moduleClass, $controllerClass, $this->action, null));
    }

    /**
     * @param $chunk
     * @return array<Routes>
     */
    protected function getRoutesByOneChunk($chunk)
    {
        $routes = [];

        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $chunk);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE, $chunk, $this->defaultController);
        $routes[] = new Route($moduleClass, $controllerClass, $this->action, null);

        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $this->defaultModule);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE, $this->defaultModule, $chunk);
        $routes[] = new Route($moduleClass, $controllerClass, $this->action, null);

        return $routes;
    }

    /**
     * @param array $chunks
     * @return array
     */
    protected function getRoutesByTwoChunks(array $chunks)
    {
        $routes = [];

        // module/controller
        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $chunks[0]);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE, $chunks[0], $chunks[1]);
        $routes[] = new Route($moduleClass, $controllerClass, $this->action, null);

        // module/defaultController/param
        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $chunks[0]);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE, $chunks[0], $this->defaultController);
        $routes[] = new Route($moduleClass, $controllerClass, $this->action, $chunks[1]);

        // defaultModule/controller/param
        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $this->defaultModule);
        $controllerClass = sprintf(self::CONTROLLER_NAMESPACE, $this->defaultModule, $chunks[0]);
        $routes[] = new Route($moduleClass, $controllerClass, $this->action, $chunks[1]);

        return $routes;
    }

    /**
     * @param array $chunks
     * @return array
     */
    protected function getRoutesByThreeChunks(array $chunks)
    {
        $moduleClass  = sprintf(self::MODULE_NAMESPACE, $chunks[0]);
        $controllerNamespace = sprintf(self::CONTROLLER_NAMESPACE, $chunks[0], $chunks[1]);
        return array(new Route($moduleClass, $controllerNamespace, $this->action, $chunks[2]));
    }


}