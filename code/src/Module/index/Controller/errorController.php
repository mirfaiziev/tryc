<?php

namespace My\Module\index\Controller;

use My\Lib\Http\Controller\AbstractController;
use My\Lib\Http\Response\AbstractResponse;

class errorController extends AbstractController
{
    /**
     * @param string $message
     */
    public function action400($message)
    {
        $this->response->setStatusCode(AbstractResponse::CODE_BAD_REQUEST);
        $this->response->setBody([
            'result'=>'Error',
            'message' => $message,
        ]);
    }

    public function action404()
    {
        $this->response->setStatusCode(AbstractResponse::CODE_NOT_FOUND);
        $this->response->setBody([
            'result'=>'Route Not Found',
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