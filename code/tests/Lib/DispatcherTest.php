<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 21.04.16
 * Time: 15:40
 */

namespace My\Lib;
use My\Lib\Dispatcher\ControllerNotFoundException;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @throws ControllerNotFoundException
     */
    public function test404Action()
    {
        $dispatcher = new Dispatcher($this->getMockConfig(), $this->getMockRouter(), $this->getMockResponse());
        $dispatcher->dispatch();
        $this->expectException(ControllerNotFoundException::class);
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
        $router = $this->getMockBuilder('My\Lib\Router\DefaultRouter')
            ->disableOriginalConstructor()
            ->setMethods(['getRoutes'])
            ->getMock();

        $router->method('getRoutes')
            ->willReturn(null);

        return $router;
    }

    protected function getMockResponse()
    {
        $response = $this->getMockBuilder('My\Lib\Response\JsonResponse')
            ->disableOriginalConstructor()
            ->getMock();

        return $response;
    }
}
