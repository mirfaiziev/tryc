<?php

namespace My\Lib;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider requestInitExceptionDataProvider
     * @expectedException \Exception
     * @param $server
     * @param $expectedException
     * @param $expectedMessage
     */
    public function testRequestInitExeption($server, $expectedException, $expectedMessage)
    {
        $request = new Request($server);
        $this->expectException($expectedException);
        $this->expectExeptionMessage($expectedMessage);
    }

    /**
     * @dataProvider requestInitCorrectDataProvider
     * @param $server
     * @param $expectedMethod
     * @param $expectedUri
     */
    public function testRequestInitCorrect($server, $expectedMethod, $expectedUri)
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
                    'aaa'=>'bbb'
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