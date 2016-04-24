<?php

namespace My\CsvDataHandler;

/**
 * Class Reader - class is responsible to read from csv file into array and get this data
 * @package My\CsvDataHandler
 */
class Reader
{
    /**
     * @var StorageInterface
     */
    protected $storage;
    
    /**
     * @var array $data
     */
    protected $data;

    /**
     * Reader constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->data = $this->storage->getData();
        
        return $this->data;  
    }
}