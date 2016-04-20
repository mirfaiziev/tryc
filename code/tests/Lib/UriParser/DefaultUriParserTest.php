<?php

namespace My\Lib\UriParser;


class DefaultUriParserTest extends \PHPUnit_Framework_TestCase
{
    public function testUriParserException()
    {

    }
    /**
     * @dataProvider uriParserDataProvider
     * @param string $uri
     * @param string $method
     * @param array $expectedRoutes
     */
    public function testDefaultUriParser($uri, $method, $expectedRoutes)
    {
        $config = $this->getMockBuilder('My\Lib\Config')
            ->setMethods(['getDefaultController', 'getDefaultModule'])
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getDefaultController')
            ->willReturn('index');
        $config->method('getDefaultModule')
            ->willReturn('index');

        $parser = new DefaultUriParser($config);
        $parser->setMethod($method);
        $parser->setUri($uri);
        $routes = $parser->getRoutes();

        $this->assertCount(count($expectedRoutes),  $routes);
        foreach ($routes as $id => $route) {
            $this->assertEquals($route->getController(), $expectedRoutes[$id]['controller']);
            $this->assertEquals($route->getAction(), $expectedRoutes[$id]['action']);
            $this->assertEquals($route->getParam(), $expectedRoutes[$id]['param']);
        }
    }

    /**
     * @dataProvider uriParserExceptionDataProvider
     * @expectedException \Exception
     * @param $uri
     * @param $method
     * @param $expectedException
     * @param $expectedMessage
     * @throws UriParserException
     */
    public function testDefaultUriParserException($uri, $method, $expectedException, $expectedMessage)
    {
        $config = $this->getMockBuilder('My\Lib\Config')
            ->setMethods(['getDefaultController', 'getDefaultModule'])
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getDefaultController')
            ->willReturn('index');
        $config->method('getDefaultModule')
            ->willReturn('index');

        $parser = new DefaultUriParser($config);
        $parser->setMethod($method);
        $parser->setUri($uri);
        $parser->getRoutes();

        $this->expectException($expectedException);
        $this->expectExeptionMessage($expectedMessage);
    }

    /**
     * @return array
     */
    public function uriParserDataProvider()
    {
        return [
            [ // set 0
                '/',
                'put',
                [
                    0 => [
                        'controller' => 'My\Module\\index\\Controller\\indexController',
                        'action' => 'putAction',
                        'param' => null,
                    ],
                ],
            ],
            [ // set 1
                '/aaa',
                'get',
                [
                    0 => [
                        'controller' => 'My\Module\\aaa\\Controller\\indexController',
                        'action' => 'getAction',
                        'param' => null,
                    ],
                    1 => [
                        'controller' => 'My\Module\\index\Controller\\aaaController',
                        'action' => 'getAction',
                        'param' => null,
                    ],
                ],
            ],
            [ // set 2
                '/aaa/bbb',
                'post',
                [
                    0 => [
                        'controller' => 'My\Module\\aaa\\Controller\\bbbController',
                        'action' => 'postAction',
                        'param' => null,
                    ],
                    1 => [
                        'controller' => 'My\Module\\aaa\\Controller\\indexController',
                        'action' => 'postAction',
                        'param' => 'bbb',
                    ],
                    2 => [
                        'controller' => 'My\Module\\index\Controller\\aaaController',
                        'action' => 'postAction',
                        'param' => 'bbb',
                    ],
                ],
            ],
            [ // set 3
                '/aaa/bbb/ccc',
                'post',
                [
                    0 => [
                        'controller' => 'My\Module\\aaa\\Controller\\bbbController',
                        'action' => 'postAction',
                        'param' => 'ccc',
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function uriParserExceptionDataProvider()
    {
        return [
            [ // set 0
                '/aaa/bbb/ccc/1234',
                'post',
                UriParserException::class,
                'Cannot parse uri: /aaa/bbb/ccc/1234',
            ],
        ];
    }
}