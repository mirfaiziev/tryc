<?php

namespace My\HttpFramework\Response;

abstract class AbstractResponse
{
    const CODE_OK = 200;
    const CODE_BAD_REQUEST = 400;
    const CODE_NOT_FOUND = 404;
    const CODE_ERROR = 500;

    const ALLOWED_CODES = [
        self::CODE_OK,
        self::CODE_BAD_REQUEST,
        self::CODE_NOT_FOUND,
        self::CODE_ERROR,
    ];

    protected $statusCode;
    protected $body;

    abstract public function sendResponse();

    /**
     * @return int
     */
    public function getStatusCode()
    {
        // no status code - something went wrong
        return isset($this->statusCode) ? $this->statusCode : self::CODE_ERROR;
    }

    /**
     * @param int $statusCode
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