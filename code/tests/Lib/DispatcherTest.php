<?php

namespace My\Lib;

use My\Lib;
use My\Lib\Dispatcher\ControllerNotFoundException;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testDispatch404()
    {
        $router = $this->getMockBuilder('Router')
                    ->setMethods(array('getRoutes'))
                    ->getMock();

        $router->method('getRoutes')
            ->willReturn(null);

        $dispatcher = new Dispatcher($router);

        $dispatcher->dispatch();
        $this->expectException(ControllerNotFoundException::class);
    }
}