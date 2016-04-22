<?php

namespace My\Lib;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider testConfigDataGetProvider
     * @param array $configuration
     * @param string $name
     * @param string $expectedValue
     */
   /* public function testConfigGet(array $configuration = null, $name, $expectedValue)
    {
        $config = new Config($configuration);
        $this->assertEquals($config->get($name), $expectedValue);
    }*/

    /**
     * @dataProvider testConfigDataCallProvider
     * @param array $configuration
     * @param string $name
     * @param string $expectedValue
     */
    public function testConfigCall(array $configuration = null, $name, $expectedValue)
    {
        $config = new Config($configuration);
        $this->assertEquals($config->{$name}(), $expectedValue);
    }

    /**
     * @return array
     */
    public function testConfigDataGetProvider()
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
                'getC',
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

    public function testConfigDataCallProvider()
    {
        return [
            [ // set 0
                [
                    'a'=>'b',
                ],
                'getC',
                null,
            ],
            [ // set 1
                [
                    'a'=>'b',
                ],
                'getA',
                'b',
            ],
        ];
    }
}