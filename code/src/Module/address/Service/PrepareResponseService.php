<?php
namespace My\Module\address\Service;

use My\HttpFramework\Dispatcher\ControllerRuntimeException;

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
    public function responseGetElement(array $row = null)
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

    /**
     * @param array|null $rows
     * @return mixed|null
     * @throws ControllerRuntimeException
     */
    public function responseGetCollection(array $rows = null)
    {
        // if empty row - return null
        if (empty($rows)) {
            return null;
        }


        $result = [];
        foreach ($rows as $row) {
            $result[] = $this->responseGetElement($row);
        }

        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    public function responseInsertedId($id)
    {
        return [
            'result' => 'success',
            'insertedID' => $id,
        ];
    }

    /**
     * @return array
     */
    public function responseOk()
    {
        return ['result' => 'success'];
    }
}