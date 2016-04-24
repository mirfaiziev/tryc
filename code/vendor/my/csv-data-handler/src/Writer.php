<?php
namespace My\CsvDataHandler;

class Writer
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * Reader constructor.
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param array $data
     */
    public function saveData(array $data)
    {
        $this->storage->saveData($data);
    }

}