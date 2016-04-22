<?php

namespace My\Lib\Http\UriParser;


class DefaultUriParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider uriParserDataProvider
     * @param string $uri
     * @param string $method
     * @param array $expectedRoutes
     */
    public function testDefaultUriParser($uri, $method, $expectedRoutes)
    {
        $config = $this->getMockConfig();

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
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedMessage);

        $config = $this->getMockConfig();

        $parser = new DefaultUriParser($config);
        $parser->setMethod($method);
        $parser->setUri($uri);
        $parser->getRoutes();
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
                        'controller' => '\\My\Module\\index1\\Controller\\index2Controller',
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
                        'controller' => '\\My\Module\\aaa\\Controller\\index2Controller',
                        'action' => 'getAction',
                        'param' => null,
                    ],
                    1 => [
                        'controller' => '\\My\Module\\index1\Controller\\aaaController',
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
                        'controller' => '\\My\Module\\aaa\\Controller\\bbbController',
                        'action' => 'postAction',
                        'param' => null,
                    ],
                    1 => [
                        'controller' => '\\My\Module\\aaa\\Controller\\index2Controller',
                        'action' => 'postAction',
                        'param' => 'bbb',
                    ],
                    2 => [
                        'controller' => '\\My\Module\\index1\Controller\\aaaController',
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
                        'controller' => '\\My\Module\\aaa\\Controller\\bbbController',
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

    /**
     * @return mixed
     */
    protected function getMockConfig()
    {
        $config = $this->getMockBuilder('My\Lib\Config')
            ->setMethods(['getDefaultController', 'getDefaultModule'])
            ->disableOriginalConstructor()
            ->getMock();

        $config->method('getDefaultController')
            ->willReturn('index2');
        $config->method('getDefaultModule')
            ->willReturn('index1');
        return $config;
    }
}