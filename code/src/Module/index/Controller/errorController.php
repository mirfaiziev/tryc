<?php

namespace My\Module\index\Controller;

use My\Lib\AbstractController;
use My\Lib\Response\AbstractResponse;

class errorController extends AbstractController
{
    public function action404()
    {
        $this->response->setStatusCode(AbstractResponse::CODE_NOT_FOUND);
        $this->response->setBody(['result'=>'Not Found']);
    }
}