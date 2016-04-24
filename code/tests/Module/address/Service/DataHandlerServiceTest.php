<?php

namespace My\Module\address\Service;

use My\CsvDataHandler\Reader;
use My\CsvDataHandler\StorageInterface;
use My\CsvDataHandler\Writer;


/**
 * Class DataHandlerServiceTest - this is not true unit test - I will not mock reader and writer.
 * I will create my own storage class which is working with array instead of file
 * @package My\Module\address\Service
 */
class ArrayStorage implements StorageInterface
{
    /**
     * @var array
     */
    protected $data;


    public function getData()
    {
        return $this->data;
    }

    public function saveData($data)
    {
        $this->data = $data;
    }
}

class DataHandlerServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataHandlerService
     */
    protected $dataHandlerService;

    public function setUp()
    {
        $this->dataHandlerService = $this->getDataHandlerService();

        // load fixture

        $this->dataHandlerService->updateAll([
            ['name1', 'street1', 'phone1'],
            ['name2', 'street2', 'phone2'],
        ]);
    }

    public function testGetElement()
    {
        $firstRow = $this->dataHandlerService->getRowById(0);

        $this->assertEquals(
            $firstRow, ['name1', 'street1', 'phone1']
        );
    }

    public function testGetCollection()
    {
        $this->assertEquals(
            $this->dataHandlerService->getRows(),
            [
                ['name1', 'street1', 'phone1'],
                ['name2', 'street2', 'phone2'],
            ]
        );
    }

    public function testGetNotExistedElement()
    {
        $this->assertNull($this->dataHandlerService->getRowById(2));
    }

    // add new element to collection
    public function testPostCollection()
    {
        $row = ['name3', 'street3', 'phone3'];
        $rowId = $this->dataHandlerService->addNewRow($row);
        $this->assertEquals($rowId, 2);
        $this->assertEquals($this->dataHandlerService->getRowById($rowId), $row);
    }

    public function testPostElementSuccess()
    {
        $row = ['name3', 'street3', 'phone3'];
        $this->assertTrue($this->dataHandlerService->updateRow(1, $row));
        $this->assertEquals($this->dataHandlerService->getRowById(1), $row);
    }

    public function testPostElementNull()
    {
        $row = ['name3', 'street3', 'phone3'];
        $this->assertFalse($this->dataHandlerService->updateRow(2, $row));
    }

    // update all
    public function testPutElementCollection()
    {
        $collection = [
            ['name10', 'street10', 'phone10'],
            ['name20', 'street20', 'phone20'],
        ];

        $this->dataHandlerService->updateAll($collection);
        $this->assertEquals($this->dataHandlerService->getRows(), $collection);
    }

    public function testDeleteCollection()
    {
        $this->dataHandlerService->deleteAll();
        $this->assertEmpty($this->dataHandlerService->getRows());
    }

    public function testDeleteElementSuccess()
    {
        $this->assertTrue($this->dataHandlerService->deleteRow(1));
        $this->assertEquals($this->dataHandlerService->getRows(), [['name1', 'street1', 'phone1']]);
    }

    public function testDeleteElementFail()
    {
        $this->assertFalse($this->dataHandlerService->deleteRow(3));
        $this->assertEquals(
            $this->dataHandlerService->getRows(),
            [
                ['name1', 'street1', 'phone1'],
                ['name2', 'street2', 'phone2'],
            ]
        );
    }

    /**
     * @return DataHandlerService
     */
    protected function getDataHandlerService()
    {
        $storage = new ArrayStorage();
        return new DataHandlerService(new Reader($storage), new Writer($storage));
    }

}
