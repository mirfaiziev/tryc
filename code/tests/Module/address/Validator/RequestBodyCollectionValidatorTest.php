<?php

namespace My\Module\address\Validator;

class RequestBodyCollectionValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider bodyCollectionValidatorDataProvider
     * @param string $body
     * @param bool $expectedIsValid
     * @param string|null $expectedError
     */
    public function testBodyCollectionValidator($body, $expectedIsValid, $expectedError = null)
    {
        $validator = new RequestBodyCollectionValidator();
        $validator->setBody($body);
        $validator->setBodyElementValidator(new RequestBodyElementValidator());

        $this->assertEquals($validator->isValid(), $expectedIsValid);

        if (!is_null($expectedError)) {
            $this->assertEquals($validator->getError(), $expectedError);
        }
    }

    /**
     * @return array
     */
    public function bodyCollectionValidatorDataProvider()
    {
        return [
            'null body' => [
                null,
                false,
                'Body should be not empty array',
            ],
            'empty body' => [
                '',
                false,
                'Body should be not empty array',
            ],
            '[]' => [
                '',
                false,
                'Body should be not empty array',
            ],
            '{}' => [
                [],
                false,
                'Body should be not empty array',
            ],
            'wrong second row' => [
                [
                    ["name" => "name1", "street" => "street1", "phone" => "phone1"],
                    ["nmae" => "name2", "street" => "street", "phone" => "phone2"],
                ],
                false,
                'Error in Row #1. Inappropriate column name \'nmae\'',
            ],
            'single row instead of body' => [
                ["name" => "name1", "street" => "street1", "phone" => "phone1"],
                false,
                'Error in Row #0. Row is not array.',
            ],
            'success' => [
                [
                    ["name" => "name1", "street" => "street1", "phone" => "phone1"],
                    ["name" => "name2", "street" => "street", "phone" => "phone2"],
                ],
                true,
            ],
        ];
    }

}
