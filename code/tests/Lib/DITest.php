<?php

namespace My\Lib;


class ServicesDITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException
     * @throws \Exception
     */
    public function _testServiceDIReturnNullForWrongName()
    {
        $this->expectException(\Exception::class);
        $servicesDI = new DI();
        $servicesDI->get('name2');
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function _testNonCallableException()
    {
        $servicesDI = new DI();
        $servicesDI->set('name1','value');
    }

    public function _testSuccess()
    {
        $servicesDI = new DI();

        $servicesDI->set('name1',function() {
            return true;
        });
        $this->assertEquals($servicesDI->get('name1'), true);
        $this->assertEquals($servicesDI->getName1(), true);
    }

    public function testSuccessWithArgs()
    {
        $servicesDI = new DI();

        $servicesDI->set('add',function($a, $b) {
            return $a+$b;
        });

        $this->assertEquals($servicesDI->get('add', 1, 2), 3);
        $this->assertEquals($servicesDI->getAdd(1,2), 3);
        $this->assertEquals($servicesDI->get('add', 4, 5), 9);
        $this->assertEquals($servicesDI->getAdd(4, 5), 9);
    }
}
