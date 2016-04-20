<?php

namespace My\Lib\Response;

class JsonResponse extends AbstractResponse
{

    public function sendResponse()
    {
        //var_dump($this->getStatusCode()); die("".__FILE__."::".__LINE__);
        http_response_code($this->getStatusCode());
        echo json_encode($this->getBody());
    }
}