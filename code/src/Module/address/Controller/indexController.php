<?php
namespace My\Module\address\Controller;

use My\HttpFramework\Dispatcher\ControllerRuntimeException;
use My\AbstractRestfulController;
use My\Module\address\Service\DataHandlerService;
use My\Module\address\Service\PrepareResponseService;
use My\Module\address\Validator\IdValidator;
use My\Module\address\Validator\RequestBodyCollectionValidator;
use My\Module\address\Validator\RequestBodyElementValidator;
use My\Module\address\Validator\RequestBodyJsonValidator;

/**
 * Class indexController
 * @package My\Module\address\Controller
 */
class indexController extends AbstractRestfulController
{
    /**
     * @var DataHandlerService
     */
    protected $dataHandler;

    /**
     * @var array $requestBody
     */
    protected $requestBody;
    /**
     * @var PrepareResponseService
     */
    protected $prepareResponse;

    public function beforeAction($id)
    {
        /**
         * @var IdValidator $idValidator
         */
        $idValidator = $this->getDi()->get('address::idValidator');
        $idValidator->setId($id);

        if (!$idValidator->isValid()) {
            throw new ControllerRuntimeException($idValidator->getError());
        }

        if (!is_null($this->request->getBody())) {
            /**
             * @var RequestBodyJsonValidator
             */
            $jsonValidator = $this->getDi()->get('address::bodyJsonValidator');
            $jsonValidator->setBodyString($this->request->getBody());

            if (!$jsonValidator->isValid()) {
                throw new ControllerRuntimeException($jsonValidator->getError());
            }

            $this->requestBody = json_decode($this->request->getBody(), true);
        }
        $this->dataHandler = $this->getDi()->get('address::dataHandlerService');
        $this->prepareResponse = $this->getDi()->get('address::prepareResponseService');
    }

    /**
     * get address element of resource by $id
     * @param string $id
     * @throws ControllerRuntimeException
     * @throws \Exception
     */
    protected function getElementAction($id)
    {
        $this->setBody(
            $this->prepareResponse
                ->responseGetElement(
                    $this->dataHandler->getRowById(intval($id))
                )
        );
    }

    /**
     * Get collection of addresses
     * @throws \Exception
     */
    protected function getCollectionAction()
    {
        $this->setBody(
            $this->prepareResponse
                ->responseGetCollection(
                    $this->dataHandler->getRows()
                )
        );
    }

    /**
     * update existing resource by id, return null if this resource does not exists
     * @param $id
     * @throws ControllerRuntimeException
     * @throws \Exception
     */
    protected function postElementAction($id)
    {


        $rows = $this->dataHandler->getRows();

        if (!isset($rows[$id])) {
            $this->returnNull();
            return;
        }

        if (!$this->dataHandler->updateRow($id, $this->requestBody)) {
            throw new ControllerRuntimeException('Updating data error: cannot find row with id ' . $id);
        }

        $this->returnOk();
    }

    /**
     * Create a new row in the addresses collection.
     */
    protected function postCollectionAction()
    {
        /**
         * @var RequestBodyElementValidator $bodyElementValidator
         */
        $bodyElementValidator = $this->getDi()->get('address::bodyElementValidator');
        $bodyElementValidator->setBody($this->requestBody);

        if (!$bodyElementValidator->isValid()) {
            throw new ControllerRuntimeException($bodyElementValidator->getError());
        }


        $insertedId = $this->dataHandler->addNewRow($this->requestBody);


        $this->setBody(
            $this->prepareResponse
                ->responseInsertedId($insertedId)
        );
    }

    /**
     * Update existing resource by id, or add new resource with this id, or return null if it's not possible
     * @param $id
     * @throws \Exception
     */
    protected function putElementAction($id)
    {
        /**
         * @var RequestBodyElementValidator $bodyElementValidator
         */
        $bodyElementValidator = $this->getDi()->get('address::bodyElementValidator');
        $bodyElementValidator->setBody($this->requestBody);

        if (!$bodyElementValidator->isValid()) {
            throw new ControllerRuntimeException($bodyElementValidator->getError());
        }

        $rows = $this->dataHandler->getRows();

        if (!isset($rows[$id])) {
            if ($id != count($rows)) {
                throw new ControllerRuntimeException('Cannot add row with id ' . $id);
            }

            $this->dataHandler->addNewRow($this->requestBody);
            $this->returnOk();

            return;
        }

        if (!$this->dataHandler->updateRow($id, $this->requestBody)) {
            throw new ControllerRuntimeException('Updating data error: cannot modify row with id ' . $id);
        }

        $this->returnOk();
    }

    /**
     * Replace the entire collection with another collection.
     */
    protected function putCollectionAction()
    {
        /**
         * @var RequestBodyCollectionValidator bodyCollectionValidator
         */
        $bodyCollectionValidator = $this->getDi()->get('address::bodyCollectionValidator');
        $bodyCollectionValidator->setBody($this->requestBody);

        if (!$bodyCollectionValidator->isValid()) {
            throw new ControllerRuntimeException($bodyCollectionValidator->getError());
        }

        $this->dataHandler->updateAll($this->requestBody);

        $this->returnOk();        
    }

    /**
     * @param $id
     * @throws ControllerRuntimeException
     */
    protected function deleteElementAction($id)
    {
        if (!$this->dataHandler->deleteRow($id)) {
            throw new ControllerRuntimeException('Deleting data error: cannot find row with id ' . $id);
        }

        $this->returnOk();
    }

    protected function deleteCollectionAction()
    {
        $this->dataHandler->deleteAll();
        $this->returnOk();
    }

    protected function returnOk()
    {
        $this->setBody(
            $this->prepareResponse->responseOk()
        );
    }

    protected function returnNull()
    {
        $this->setBody(
            $this->prepareResponse->responseNull()
        );
    }
}
