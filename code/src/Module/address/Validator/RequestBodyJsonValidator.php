<?php

namespace My\Module\address\Validator;

use My\AbstractValidator;

class RequestBodyJsonValidator extends AbstractValidator
{
    /**
     * @var string $bodyString
     */
    protected $bodyString;

    /**
     * @param string $bodyString
     */
    public function setBodyString($bodyString)
    {
        $this->bodyString = $bodyString;
    }

    /**
     * @return true
     */
    public function isValid()
    {
        json_decode($this->bodyString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = 'Error parsing request body';
            return false;
        }

        return true;
    }
}