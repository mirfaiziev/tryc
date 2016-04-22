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
    public function testNonCallableException()
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
}
