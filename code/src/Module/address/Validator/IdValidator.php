<?php

namespace My\Module\address\Validator;

use My\Module\AbstractValidator;

class IdValidator extends AbstractValidator
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $error
     */
    protected $error;

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function isValid()
    {
        if (is_null($this->id)) {
            return true;
        }

        if (empty($this->id)) {
            $this->error = 'Id should not be empty';
            return false;
        }

        if (0 == intval($this->id) && "0" != $this->id) {
            $this->error = 'Wrong id \'' . $this->id . '\'';
            return false;
        }
        return true;
    }

    public function getError()
    {
       return $this->error;
    }
}