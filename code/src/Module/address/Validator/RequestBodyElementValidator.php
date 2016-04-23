<?php
namespace My\Module\address\Validator;

use My\Lib\AbstractValidator;

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
     * @var string $body
     */
    protected $body;

    /**
     * @param string $body
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
        $body = json_decode($this->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = 'Error parsing request body';
            return false;
        }

        if (count($body) != count(self::ALLOWED_COLUMNS)) {
            $this->error = 'Number of params should be equal to number of allowed columns: ' . count(self::ALLOWED_COLUMNS);
            return false;
        }

        foreach ($body as $key => $value) {
            if (!in_array($key, self::ALLOWED_COLUMNS)) {
                $this->error = 'Inappropriate column name ' . $key;
                return false;
            }
        }

        foreach (self::ALLOWED_COLUMNS as $columnName) {
            if (!isset($body[$columnName])) {
                $this->error = 'Column ' . $columnName . ' is missed';
                return false;
            }
        }

        return true;
    }
}