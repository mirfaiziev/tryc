<?php

namespace My\HttpFramework;

class RouteTest extends \PHPUnit_Framework_TestCase
{
    public function testRoute()
    {
        $route = new Route('aaaa', 'bbb', 'cc', 'd');
        $this->assertEquals($route->getModule(), 'aaaa');
        $this->assertEquals($route->getController(), 'bbb');
        $this->assertEquals($route->getAction(), 'cc');
        $this->assertEquals($route->getParam(), 'd');
    }
}
