<?php
namespace My\Module\address\Controller;

use My\Lib\Http\Controller\AbstractRestfulController;
use My\Lib\Http\Dispatcher\ControllerRuntimeException;
use My\Module\address\Service\DataHandlerService;
use My\Module\address\Service\PrepareResponseService;
use My\Module\address\Validator\IdValidator;
use My\Module\address\Validator\RequestBodyCollectionValidator;
use My\Module\address\Validator\RequestBodyElementValidator;

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
     * @var PrepareResponseService
     */
    protected $prepareResponse;

    public function beforeAction($id)
    {
        /**
         * @var IdValidator $idValidator
         */
        $idValidator = $this->di->get('address::idValidator');
        $idValidator->setId($id);

        if (!$idValidator->isValid()) {
            throw new ControllerRuntimeException($idValidator->getError());
        }

        $this->dataHandler = $this->di->get('address::dataHandlerService');
        $this->prepareResponse = $this->di->get('address::prepareResponseService');
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
     * update existing resource by id, return null if this resource doesn't exists
     * @throws ControllerRuntimeException
     * @throws \Exception
     */
    protected function postElementAction($id)
    {
        $body = $this->request->getBody();
        /**
         * @var RequestBodyElementValidator $bodyElementValidator
         */
        $bodyElementValidator = $this->di->get('address::bodyElementValidator');
        $bodyElementValidator->setBody($body);


        $rows = $this->dataHandler->getRows();

        if (!isset($rows[$id])) {
            throw new ControllerRuntimeException('Cannot find row with id ' . $id);
        }

        if (!$this->dataHandler->updateRow($id, json_decode($this->request->getBody(), true))) {
            throw new ControllerRuntimeException('Updating data error: cannot find row with id: ' . $id);
        }

        $this->returnOk();
    }

    /**
     * Create a new row in the addresses collection.
     */
    protected function postCollectionAction()
    {
        $body = $this->request->getBody();
        /**
         * @var RequestBodyElementValidator $bodyElementValidator
         */
        $bodyElementValidator = $this->di->get('address::bodyElementValidator');
        $bodyElementValidator->setBody($body);

        if (!$bodyElementValidator->isValid()) {
            throw new ControllerRuntimeException($bodyElementValidator->getError());
        }

        $insertedId = $this->dataHandler->addNewRow(json_decode($this->request->getBody(), true));


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
        $body = $this->request->getBody();
        /**
         * @var RequestBodyElementValidator $bodyElementValidator
         */
        $bodyElementValidator = $this->di->get('address::bodyElementValidator');
        $bodyElementValidator->setBody($body);


        $rows = $this->dataHandler->getRows();

        if (!isset($rows[$id])) {
            throw new ControllerRuntimeException('Cannot find row with id ' . $id);
        }

        if (!$this->dataHandler->updateRow($id, json_decode($this->request->getBody(), true))) {
            throw new ControllerRuntimeException('Updating data error: cannot find row with id: ' . $id);
        }

        $this->returnOk();
    }

    /**
     * Replace the entire collection with another collection.
     */
    protected function putCollectionAction()
    {
        $body = $this->request->getBody();
        /**
         * @var RequestBodyCollectionValidator $bodyCollectionValidator
         */
        $bodyCollectionValidator = $this->di->get('address::bodyCollectionValidator');
        $bodyCollectionValidator->setBody($body);

        $this->dataHandler->updateAll($body);

        $this->returnOk();        
    }

    /**
     * @param $id
     * @throws ControllerRuntimeException
     */
    protected function deleteElementAction($id)
    {
        if (!$this->dataHandler->deleteRow($id)) {
            throw new ControllerRuntimeException('Deleting data error: cannot find row with id: ' . $id);
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
}
