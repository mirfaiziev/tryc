<?php

namespace My\App;

abstract class AbstractValidator
{
    /**
     * @var string $error
     */
    protected $error;

    abstract public function isValid();

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}