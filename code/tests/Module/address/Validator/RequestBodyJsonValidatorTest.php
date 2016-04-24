<?php

namespace My\Module\address\Validator;

class RequestBodyJsonValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider bodyJsonValidatorDataProvider
     * @param string $body
     * @param $expectedIsValid
     */
    public function testBodyJsonValidator($body, $expectedIsValid)
    {
        $jsonValidator = new RequestBodyJsonValidator();
        $jsonValidator->setBodyString($body);
        $this->assertEquals($jsonValidator->isValid(), $expectedIsValid);
    }

    public function bodyJsonValidatorDataProvider()
    {
        return [
            'invalid json' => [
                '{"a":"b}',
                false,
            ],
            'valid json' => [
                '{"a":"b"}',
                true,
            ],
        ];
    }
}
