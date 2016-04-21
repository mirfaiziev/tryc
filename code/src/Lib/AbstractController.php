<?php

namespace My\Lib;

use My\Lib\Response\AbstractResponse;

/**
 * Class Controller - each controller's action return response
 * @package My\Lib
 */
abstract class AbstractController
{
    const DEFAULT_STATUS_CODE = AbstractResponse::CODE_OK;
    /**
     * @var AbstractResponse
     */
    protected $response;

    /**
     * AbstractController constructor.
     * @param AbstractResponse $response
     */
    public function __construct(AbstractResponse $response)
    {
        $this->response = $response;
        $this->response->setStatusCode(self::DEFAULT_STATUS_CODE);
    }

    /**
     * @return AbstractResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
    
}