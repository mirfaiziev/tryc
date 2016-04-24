<?php

namespace My\Module\address\Validator;


class RequestBodyElementValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider bodyElementValidatorDataProvider
     * @param string $body
     * @param bool $expectedIsValid
     * @param string|null $expectedError
     */
    public function testBodyElementValidator($body, $expectedIsValid, $expectedError = null)
    {
        $validator = new RequestBodyElementValidator();
        $validator->setBody($body);

        $this->assertEquals($validator->isValid(), $expectedIsValid);

        if (!is_null($expectedError)) {
            $this->assertEquals($validator->getError(), $expectedError);
        }
    }


    public function bodyElementValidatorDataProvider()
    {
        return [
            'null body' => [
                null,
                false,
                'Number of params should be equal to number of allowed columns: 3',
            ],
            'empty body' => [
                '',
                false,
                'Number of params should be equal to number of allowed columns: 3',
            ],
            'inappropriate name' => [
                ["name" => "name", "street" => "street", "phome" => "123"],
                false,
                'Inappropriate column name \'phome\'',
            ],
            'success' => [
                ["name" => "name", "street" => "street", "phone" => "123"],
                true,
            ],
        ];
    }
}
