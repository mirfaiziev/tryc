<?php

namespace My\Module\address\Service;

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
     * @var array $data
     */
    protected $data;

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

    /**
     * @param int $id
     * @return array | null
     */
    public function getRowById($id)
    {
        if (!isset($this->data)) {
            $this->reader->read();
            $this->data = $this->reader->getData();
        }

        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        $this->reader->read();
        $this->data = $this->reader->getData();
        return $this->data;
    }

    /**
     * @param array $row
     * @return int - last insert id :)
     */
    public function addNewRow(array $row)
    {
        $this->reader->read();
        $this->data = $this->reader->getData();
        $this->data[] = $row;

        $this->writer->saveData($this->data);

        return count($this->data);
    }

    /**
     * @param $id
     * @param array $row
     * @return bool
     */
    public function updateRow($id, array $row)
    {
        if (!isset($this->data)) {
            $this->reader->read();
            $this->data = $this->reader->getData();
        }

        if (!isset($this->data[$id])) {
            return false;
        }

        $this->data[$id] = $row;

        $this->writer->saveData($this->data);

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteRow($id)
    {
        if (!isset($this->data)) {
            $this->reader->read();
            $this->data = $this->reader->getData();
        }

        if (!isset($this->data[$id])) {
            return false;
        }

        unset($this->data[$id]);

        $this->writer->saveData($this->data);

        return true;
    }

    public function deleteAll()
    {
        $this->writer->saveData([]);
    }

    /**
     * @param array $rows
     */
    public function updateAll(array $rows)
    {
        $this->writer->saveData($rows);
    }

}