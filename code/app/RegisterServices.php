<?php

namespace App;

use My\HttpFramework\Dispatcher;
use My\HttpFramework\Request;
use My\HttpFramework\Response\JsonResponse;
use My\HttpFramework\Router\DefaultRouter;
use My\HttpFramework\UriParser\DefaultUriParser;

class RegisterServices implements RegisterServicesInterface
{
    public static function init()
    {
        $app = App::getInstance();

        $di = $app->getDi();

        $di->set('app::dispatcher', function () use ($di) {
            $config = $di->get('config');
            $request = new Request();
            $response = new JsonResponse();
            $uriParser = new DefaultUriParser($config);
            $router = new DefaultRouter($request, $uriParser);

            return new Dispatcher($config, $router, $request, $response);
        });
    }
}