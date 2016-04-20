<?php

namespace My\Lib;

use My\Lib\Response\AbstractResponse;

/**
 * Class Controller - each controller's action return response
 * @package My\Lib
 */
abstract class AbstractController
{
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
    }

    /**
     * @return AbstractResponse
     */
    public function getResponse()
    {
        return $this->response;
    }
    
}