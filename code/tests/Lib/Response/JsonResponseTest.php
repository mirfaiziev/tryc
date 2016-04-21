<?php

namespace My\Lib\Response;

class JsonResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider responseDataProvider
     * @param $body
     * @param $expectedResponse
     */
    public function testResponse($body, $expectedResponse)
    {
        $this->expectOutputString($expectedResponse);
        $response = new JsonResponse();
        $response->setBody($body);
        $response->sendResponse();
    }

    /**
     * @return array
     */
    public function responseDataProvider()
    {
        return [
            [ // set 0
                'aaa',
                '"aaa"',
            ],
            [ // set 1
                [
                    'result' => 'ok'
                ],
                '{"result":"ok"}',
            ],
        ];
    }
}
