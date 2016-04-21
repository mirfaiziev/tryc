<?php

namespace My\Module\index\Controller;

use My\Lib\Http\Controller\AbstractController;
use My\Lib\Http\Response\AbstractResponse;

class errorController extends AbstractController
{
    /**
     * @param string $controller
     * @param string $method
     */
    public function action404_($controller, $method)
    {
        $this->response->setStatusCode(AbstractResponse::CODE_NOT_FOUND);
        $this->response->setBody([
            'result'=>'Route Not Found',
            'controller' => $controller,
            'method' => $method,
        ]);
    }

    /**
     * @param string $message
     */
    public function action500($message)
    {
        $this->response->setStatusCode(AbstractResponse::CODE_ERROR);
        $this->response->setBody([
            'result'=>'Internal Server Error',
            'message' => $message,
        ]);
    }
}