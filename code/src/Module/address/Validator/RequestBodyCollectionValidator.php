<?php

namespace My\Module\address\Validator;

use My\App\App;
use My\Lib\AbstractValidator;

class RequestBodyCollectionValidator extends AbstractValidator
{
    /**
     * @var string $body
     */
    protected $body;

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @inheritdoc
     */
    public function isValid()
    {
        $body = json_decode($this->body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error = 'Error parsing request body';
            return false;
        }

        if (!is_array($body) || empty($body)) {
            $this->error = 'Body should be not empty array';
            return false;
        }

        /**
         * @var RequestBodyElementValidator $rowValidator
         */
        $rowValidator = App::getInstance()->getDi()->get('address::bodyElementValidator');
        foreach ($body as $row) {
            $rowValidator->setBody($row);
            if (!$rowValidator->isValid()) {
                $this->error = $rowValidator->getError();
                return false;
            }
        }

        return true;
    }
}