<?php
namespace My\Module\address\Validator;

class IdValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider idValidatorDataProvider
     * @param string $id
     * @param $expectedIsValid
     * @param $expectedError
     */
    public function testIdValidator($id, $expectedIsValid, $expectedError = null)
    {
        $validator = new IdValidator();
        $validator->setId($id);
        $this->assertEquals($validator->isValid(), $expectedIsValid);

        if (!is_null($expectedError)) {
            $this->assertEquals($validator->getError(), $expectedError);
        }
    }

    /**
     * @return array
     */
    public function idValidatorDataProvider()
    {
        return [
            'id is null' => [ // set 0 id is null
                null,
                true,
            ],
            'empty id' => [ // set 1 - empty id
                '',
                false,
                'Id should not be empty',
            ],
            'letters in id' => [ // set 2
                'a123',
                false,
                'Wrong id \'a123\'',
            ],
            'zero should be handled correctly' => [
                '0',
                true,
            ],
            'numbers should be handler correctly' => [
                '123',
                true,
            ],
        ];
    }
}
