<?php

namespace My;

use App\App;
use My\Di\DI;
use My\HttpFramework\ControllerInterface;
use My\HttpFramework\Dispatcher\ControllerRuntimeException;
use My\HttpFramework\Request;
use My\HttpFramework\Response\AbstractResponse;

/**
 * Class Controller - each controller's action return response
 * @package My\HttpFramework
 */
abstract class AbstractController implements ControllerInterface
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
    }

    /**
     * @return AbstractResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return DI
     */
    public function getDi()
    {
        return App::getInstance()->getDi();
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