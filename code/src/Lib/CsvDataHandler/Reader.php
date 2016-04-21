<?php

namespace My\Lib\CsvDataHandler;

/**
 * Class Reader - class is responsible to read from csv file into array and get this data
 * @package My\Lib\CsvDataHandler
 */
class Reader
{
    /**
     * @var string $filename
     */
    protected $filename;

    /**
     * @var array $data
     */
    protected $data;
    /**
     * Reader constructor.
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function read()
    {
        if (!file_exists($this->filename)) {
            throw new \RuntimeException("Csv handler cannot read the file. File " . $this->filename . " is not found.");
        }

        if (!is_readable($this->filename)) {
            throw new \RuntimeException("Csv handler cannot read the file. File " . $this->filename . " is not readable.");
        }

        $fp = fopen($this->filename, 'r');

        if (flock($fp, LOCK_SH | LOCK_NB )) {
            while ($data = fgetcsv($fp)) {
                $this->data[] = $data;
            }
            flock($fp, LOCK_UN);
        }

        fclose($fp);
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}