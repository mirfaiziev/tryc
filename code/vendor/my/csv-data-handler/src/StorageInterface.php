<?php

namespace My\CsvDataHandler;

interface StorageInterface
{
    public function getData();

    public function saveData($data);
}