<?php
namespace My\CsvDataHandler;

class FileStorage implements StorageInterface
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var
     */
    protected $data;

    /**
     * FileStorage constructor.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }


    public function getData()
    {
        if (is_null($this->data)) {
            $this->data = $this->loadData();
        }
        return $this->data;
    }

    public function saveData($data)
    {
        if (!is_writable($this->filePath)) {
            throw new \RuntimeException("Csv handler cannot write the file. File " . $this->filePath . " is not writable.");
        }

        $fp = fopen($this->filePath, 'w');
        if (flock($fp, LOCK_EX | LOCK_NB)) {
            foreach ($data as $line) {
                fputcsv($fp, $line);
            }
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

    protected function loadData()
    {
        $loadedData = [];

        if (!file_exists($this->filePath)) {
            throw new \RuntimeException("Csv handler cannot read the file. File " . $this->filePath . " is not found.");
        }

        if (!is_readable($this->filePath)) {
            throw new \RuntimeException("Csv handler cannot read the file. File " . $this->filePath . " is not readable.");
        }

        $fp = fopen($this->filePath, 'r');

        if (flock($fp, LOCK_SH | LOCK_NB)) {
            while ($data = fgetcsv($fp)) {
                $loadedData[] = $data;
            }
            flock($fp, LOCK_UN);
        }

        fclose($fp);

        return $loadedData;
    }

}