<?php
namespace My\Lib\CsvDataHandler;

class Writer
{
    protected $filename;

    /**
     * Writer constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param array $data
     */
    public function saveData(array $data)
    {
        if (!is_writable($this->filename)) {
            throw new \RuntimeException("Csv handler cannot write the file. File " . $this->filename . " is not writeable.");
        }

        $fp = fopen($this->filename, 'w');
        if (flock($fp, LOCK_EX | LOCK_NB )) {
            foreach ($data as $line) {
                fputcsv($fp, $line);
            }
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

}