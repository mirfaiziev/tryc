<?php

namespace My\HttpFramework\Response;

class JsonResponse extends AbstractResponse
{

    public function sendResponse()
    {
        $body = $this->getBody();
        http_response_code($this->getStatusCode());
        echo json_encode($body);
    }
}