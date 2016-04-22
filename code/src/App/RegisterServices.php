<?php

namespace My\App;

use My\Lib\DI;
use My\Lib\Http\Request;
use My\Lib\RegisterServicesInterface;

use My\Lib\Http\Dispatcher;
use My\Lib\Http\Response\JsonResponse;
use My\Lib\Http\Router\DefaultRouter;
use My\Lib\Http\UriParser\DefaultUriParser;

class RegisterServices implements RegisterServicesInterface
{
    public static function init()
    {
        /**
         * @var DI $di;
         */
        $di = App::getInstance()->getDI();
        $config = App::getInstance()->getConfig();

        $di->set('app::dispatcher', function() use ($config) {
            $request = new Request();
            $response = new JsonResponse();
            $uriParser = new DefaultUriParser($config);
            $router = new DefaultRouter($request, $uriParser);

            return new Dispatcher($config, $router, $request, $response);
        });
    }
}
