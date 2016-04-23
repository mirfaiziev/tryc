<?php

namespace My\App;

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
        $app = App::getInstance();

        $di = $app->getDi();

        $di->set('app::dispatcher', function() use ($di) {
            $config = $di->get('config');
            $request = new Request();
            $response = new JsonResponse();
            $uriParser = new DefaultUriParser($config);
            $router = new DefaultRouter($request, $uriParser);

            return new Dispatcher($config, $router, $request, $response);
        });
    }
}
