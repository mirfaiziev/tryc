<?php

namespace My\HttpFramework\Router;

class DefaultRouterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * simple test - use mock, just make sure we get the same routes from uri parser
     */
    public function testDefaultRouter()
    {
        $request = $this->getMockBuilder('My\HttpFramework\Request')
            ->setMethods(['getMethod', 'getUri'])
            ->disableOriginalConstructor()
            ->getMock();

        $request->method('getMethod')
            ->willReturn('some');

        $request->method('getUri')
            ->willReturn('/some/uri');

        $uriParser = $this->getMockBuilder('My\HttpFramework\UriParser\DefaultUriParser')
            ->setMethods(['getRoutes'])
            ->disableOriginalConstructor()
            ->getMock();

        $uriParser->method('getRoutes')
            ->willReturn('some routes');

        $router = new DefaultRouter($request, $uriParser);

        $this->assertEquals($router->getRoutes(), 'some routes');
    }
}