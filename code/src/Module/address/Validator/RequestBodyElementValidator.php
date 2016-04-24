<?php
namespace My\Module\address\Validator;

use My\AbstractValidator;

class RequestBodyElementValidator extends AbstractValidator
{
    const COLUMN_NAME = 'name';
    const COLUMN_PHONE = 'phone';
    const COLUMN_STREET = 'street';

    const ALLOWED_COLUMNS = [
        self::COLUMN_NAME,
        self::COLUMN_PHONE,
        self::COLUMN_STREET,
    ];

    /**
     * @var array $body
     */
    protected $body;

    /**
     * @param array $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @inheritdoc
     */
    public function isValid()
    {
        if (count($this->body) != count(self::ALLOWED_COLUMNS)) {
            $this->error = 'Number of params should be equal to number of allowed columns: ' . count(self::ALLOWED_COLUMNS);
            return false;
        }

        foreach ($this->body as $key => $value) {
            if (!in_array($key, self::ALLOWED_COLUMNS)) {
                $this->error = 'Inappropriate column name \'' . $key . '\'';
                return false;
            }
        }

        return true;
    }
}