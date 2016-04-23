<?php

namespace My\Lib\Http\Controller;

use My\App\App;
use My\Lib\DI;
use My\Lib\Http\Dispatcher\ControllerRuntimeException;
use My\Lib\Http\Request;
use My\Lib\Http\Response\AbstractResponse;

/**
 * Class Controller - each controller's action return response
 * @package My\Lib\Http
 */
abstract class AbstractController
{
    const DEFAULT_STATUS_CODE = AbstractResponse::CODE_OK;

    /**
     * @var DI
     */
    protected $di;

    /**
     * @var Request $request
     */
    protected $request;
    /**
     * @var AbstractResponse
     */
    protected $response;

    /**
     * AbstractController constructor.
     * @param Request $request
     * @param AbstractResponse $response
     */
    public function __construct(Request $request, AbstractResponse $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->response->setStatusCode(self::DEFAULT_STATUS_CODE);
        $this->di = App::getInstance()->getDi();
    }

    /**
     * @return AbstractResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $body
     */
    protected function setBody($body)
    {
        $this->response->setBody($body);
    }

    /**
     * @param $code
     * @throws ControllerRuntimeException
     */
    protected function setStatusCode($code)
    {
        if (!in_array($code, AbstractResponse::ALLOWED_CODES)) {
            throw new ControllerRuntimeException("Disallowed status code: ".$code);
        }
        $this->response->setStatusCode($code);
    }
}