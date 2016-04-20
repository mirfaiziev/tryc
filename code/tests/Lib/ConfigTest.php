<?php

namespace My\Lib;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testConfigDataProvider
     * @param array $configuration
     * @param string $name
     * @param string $expectedValue
     */
    public function testConfig(array $configuration = null, $name, $expectedValue)
    {
        $config = new Config($configuration);
        $this->assertEquals($config->get($name), $expectedValue);
    }

    /**
     * @return array
     */
    public function testConfigDataProvider()
    {
        return [
            [ // set 0
                null,
                null,
                null,
            ],
            [ // set 1
                [
                    'a'=>'b',
                ],
                'c',
                null,
            ],
            [ // set 2
                [
                    'a'=>'b',
                ],
                'a',
                'b',
            ],
        ];
    }
}