<?php

namespace My\Module\address\Service;

use My\CsvDataHandler\Reader;
use My\CsvDataHandler\Writer;

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
     * @param $reader
     * @param $writer
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
        if (is_null($this->data)) {
            $this->data = $this->reader->getData();
        }
        return isset($this->data[$id]) ? $this->data[$id] : null;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        $this->data = $this->reader->getData();
        return $this->data;
    }

    /**
     * @param array $row
     * @return int - last insert id :)
     */
    public function addNewRow(array $row)
    {
        $this->data = $this->reader->getData();
        $this->data[] = $row;

        $this->writer->saveData($this->data);

        return count($this->data) - 1;
    }

    /**
     * @param $id
     * @param array $row
     * @return bool
     */
    public function updateRow($id, array $row)
    {
        $this->data = $this->reader->getData();

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
        $this->data = $this->reader->getData();

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