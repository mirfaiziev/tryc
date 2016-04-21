<?php

namespace My\Lib\Response;

class JsonResponse extends AbstractResponse
{

    public function sendResponse()
    {
        http_response_code($this->getStatusCode());
        echo json_encode($this->getBody());
    }
}