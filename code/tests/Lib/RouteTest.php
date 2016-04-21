<?php

namespace My\Lib;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testRoute()
    {
        $route = new Route('aaaa', 'bbb', 'cc');
        $this->assertEquals($route->getController(), 'aaaa');
        $this->assertEquals($route->getAction(), 'bbb');
        $this->assertEquals($route->getParam(), 'cc');
    }
}
