<?php

namespace My\Module\address\Validator;

use My\AbstractValidator;

class RequestBodyCollectionValidator extends AbstractValidator
{
    /**
     * @var RequestBodyCollectionValidator
     */
    protected $bodyElementValidator;

    /**
     * @var array
     * $body
     */
    protected $body;

    /**
     * @param array $body
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
        if (!is_array($this->body) || empty($this->body)) {
            $this->error = 'Body should be not empty array';
            return false;
        }

        $rowValidator = $this->getBodyElementValidator();

        $count = 0; // use count instead of id cause row might not me an array
        foreach ($this->body as $row) {
            if (!is_array($row)) {
                $this->error = 'Error in Row #' . $count . '. Row is not array.';
                return false;
            }

            $rowValidator->setBody($row);
            if (!$rowValidator->isValid()) {
                $this->error = 'Error in Row #' . $count . '. ' . $rowValidator->getError();
                return false;
            }
            $count++;
        }

        return true;
    }

    /**
     * @return RequestBodyCollectionValidator
     */
    public function getBodyElementValidator()
    {
        return $this->bodyElementValidator;
    }

    /**
     * @param RequestBodyElementValidator $bodyElementValidator
     */
    public function setBodyElementValidator($bodyElementValidator)
    {
        $this->bodyElementValidator = $bodyElementValidator;
    }
}