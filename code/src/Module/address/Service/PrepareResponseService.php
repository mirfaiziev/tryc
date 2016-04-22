<?php
namespace My\Module\address\Service;

use My\Lib\Http\Dispatcher\ControllerRuntimeException;

class PrepareResponseService
{
    const COLUMN_NUMBER = 3;
    /**
     * @var array|null $row
     */
    protected $row;

    /**
     * @param array|null $row
     * @return array|null
     * @throws ControllerRuntimeException
     */
    public function responseGet(array $row = null)
    {
        // if empty row - return null
        if (empty($row)) {
            return null;
        }

        if (!is_array($row) || count($row) != self::COLUMN_NUMBER) {
            throw new ControllerRuntimeException('Incorrect data row from file.' . serialize($row));
        }

        return [
            'name' => $row[0],
            'phone' => $row[1],
            'street' => $row[2],
        ];
    }
}