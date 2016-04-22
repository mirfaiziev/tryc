<?php

namespace My\Module\address\Validator;

use My\Lib\AbstractValidator;

class IncomingParamValidator extends AbstractValidator
{
    /**
     * @var string $param
     */
    protected $param;

    /**
     * @var string $error
     */
    protected $error;
    /**
     * IncomingDataValidator constructor.
     * @param string $param
     */
    public function __construct($param)
    {
        $this->param = $param;
    }


    public function isValid()
    {
        if (0 == intval($this->param) && "0" != $this->param) {
            $this->error = 'Wrong param \''.$this->param.'\'';
            return false;
        }
        return true;
    }

    public function getError()
    {
       return $this->error;
    }
}