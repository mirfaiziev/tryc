<?php

namespace My\Lib;


class ServicesDITest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException
     * @throws \Exception
     */
    public function testServiceDIReturnNullForWrongName()
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

    public function testSuccess()
    {
        $servicesDI = new DI();

        $servicesDI->set('name1',function() {
            return true;
        });
        $this->assertEquals($servicesDI->get('name1'), true);
        $this->assertEquals($servicesDI->getName1(), true);
    }

    public function testSingleExecution()
    {
        $servicesDI = new DI();

        $servicesDI->set('time',function() {
            return microtime(true);
        });

        $result1 = $servicesDI->get('time');
        usleep(10);
        $this->assertEquals($servicesDI->get('time'), $result1);
    }
}
