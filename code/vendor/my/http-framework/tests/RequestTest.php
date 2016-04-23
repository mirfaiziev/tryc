<?php

namespace My\HttpFramework;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider requestInitExceptionDataProvider
     * @expectedException \Exception
     * @param array $server
     * @param \Exception $expectedException
     * @param string $expectedMessage
     */
    public function testRequestInitExeption($server, $expectedException, $expectedMessage)
    {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedMessage);
        new Request($server);
    }

    /**
     * @dataProvider requestInitCorrectDataProvider
     * @param array $server
     * @param string $expectedMethod
     * @param string $expectedUri
     */
    public function testRequestInitCorrect(array $server, $expectedMethod, $expectedUri)
    {
        $request = new Request($server);
        $this->assertEquals($request->getMethod(), $expectedMethod);
        $this->assertEquals($request->getUri(), $expectedUri);
    }

    /**
     * @return array
     */
    public function requestInitExceptionDataProvider()
    {
        return [
            [   // set 0 - no server
                null,
                \InvalidArgumentException::class,
                'Cannot define request method',
            ],
            [ // Set 1 - wrong server
                [
                    'aaa' => 'bbb'
                ],
                \InvalidArgumentException::class,
                'Cannot define request method',
            ],
            [ // set 2 - wrong method
                [
                    'REQUEST_METHOD' => 'very_specific'
                ],
                \DomainException::class,
                'Incorrect method: very_specific',
            ],
            [ // set 3 - no uri
                [
                    'REQUEST_METHOD' => 'put'
                ],
                \InvalidArgumentException::class,
                'Cannot define request uri',
            ],
        ];
    }

    /**
     * @return array
     */
    public function requestInitCorrectDataProvider()
    {
        return [
            [ // set 0
                [
                    'REQUEST_METHOD' => 'GET',
                    'REQUEST_URI' => '/some/REST/Call',
                ],
                'get',
                '/some/rest/call',
            ]
        ];
    }
}