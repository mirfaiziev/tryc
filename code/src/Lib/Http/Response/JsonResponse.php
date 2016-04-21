<?php

namespace My\Lib\Http\Response;

class JsonResponse extends AbstractResponse
{

    public function sendResponse()
    {
        $body = $this->getBody();
        http_response_code($this->getStatusCode());
        if (!empty($body)) {
            echo json_encode($body);

        }
    }
}