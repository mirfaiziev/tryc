<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 21.04.16
 * Time: 15:40
 */

namespace My\Lib\Http;
use My\Lib\Http\Dispatcher\ControllerNotFoundException;
use My\Lib\Config;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @throws ControllerNotFoundException
     */
    public function test404Action()
    {
        $this->expectException(ControllerNotFoundException::class);

        $dispatcher = new Dispatcher(
            $this->getMockConfig(),
            $this->getMockRouter(),
            $this->getMockRequest(),
        $this->getMockResponse());

        $dispatcher->dispatch();
    }

    /**
     * @return Config
     */
    protected function getMockConfig()
    {
        $config = $this->getMockBuilder('My\Lib\Config')
            ->disableOriginalConstructor()
            ->setMethods(['getErrorController', 'getAction404', 'getAction500'])
            ->getMock();

        return $config;
    }

    protected function getMockRouter()
    {
        $router = $this->getMockBuilder('My\Lib\Http\Router\DefaultRouter')
            ->disableOriginalConstructor()
            ->setMethods(['getRoutes'])
            ->getMock();

        $router->method('getRoutes')
            ->willReturn(null);

        return $router;
    }

    protected function getMockRequest()
    {
        $request = $this->getMockBuilder('My\Lib\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();

        return $request;
    }

    protected function getMockResponse()
    {
        $response = $this->getMockBuilder('My\Lib\Http\Response\JsonResponse')
            ->disableOriginalConstructor()
            ->getMock();

        return $response;
    }
}
