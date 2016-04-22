<?php

namespace My\Module\address\Service;

use My\App\App;
use My\Lib\CsvDataHandler\Reader;
use My\Lib\CsvDataHandler\Writer;

class DataHandlerService
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var Writer
     */
    protected $writer;

    /**
     * DataHandlerService constructor.
     * @param Reader $reader
     * @param Writer $writer
     */
    public function __construct(Reader $reader, Writer $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    public function getRowById($id)
    {
        $this->reader->read();
        return isset($this->reader->getData()[$id]) ? $this->reader->getData()[$id] : null;
    }

    public function addNewRow($data)
    {

    }

    public function updateRow($id, $row)
    {

    }

    public function deleteRow($id)
    {

    }

}