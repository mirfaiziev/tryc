<?php

namespace My\Module\index\Controller;

use My\HttpFramework\ControllerInterface;
use My\HttpFramework\Response\AbstractResponse;
use My\AbstractController;

class errorController extends AbstractController implements ControllerInterface
{
    /**
     * @param string $message
     */
    public function action400($message)
    {
        $this->setStatusCode(AbstractResponse::CODE_BAD_REQUEST);
        $this->setBody([
            'result'=>'Error',
            'message' => $message,
        ]);
    }

    public function action404()
    {
        $this->setStatusCode(AbstractResponse::CODE_NOT_FOUND);
        $this->setBody([
            'result'=>'Route Not Found',
        ]);
    }

    /**
     * @param string $message
     */
    public function action500($message)
    {
        $this->setStatusCode(AbstractResponse::CODE_ERROR);
        $this->setBody([
            'result'=>'Internal Server Error',
            'message' => $message,
        ]);
    }
}