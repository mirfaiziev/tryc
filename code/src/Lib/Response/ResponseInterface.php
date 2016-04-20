<?php

namespace My\Lib\Response;

abstract class AbstractResponse
{
    const CODE_OK = '200';
    const CODE_NOT_FOUND = '404';
    const CODE_ERROR = '500';

    const ALLOWED_CODES = [
        self::CODE_OK,
        self::CODE_NOT_FOUND,
        self::CODE_ERROR,
    ];

    protected $statusCode;
    protected $body;

    abstract public function sendResponse();

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }


}