<?php

namespace My;

abstract class AbstractValidator
{
    /**
     * @var string $error
     */
    protected $error;

    /**
     * @return bool
     */
    abstract public function isValid();

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}