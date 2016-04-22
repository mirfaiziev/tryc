<?php
namespace My\Module\address\Controller;

use My\App\App;
use My\Lib\AbstractValidator;
use My\Lib\Http\Controller\AbstractController;
use My\Lib\Http\Dispatcher\ControllerRuntimeException;
use My\Module\address\Service\DataHandlerService;

class indexController extends AbstractController
{
    /**
     * @param $param
     * @throws ControllerRuntimeException
     */
    public function getAction($param)
    {
        $di = App::getInstance()->getDi();
        /**
         * @var AbstractValidator
         */
        $validator = $di->get('address::incomingParamValidator');
        $validator->setParam($param);

        if (!$validator->isValid()) {
            throw new ControllerRuntimeException($validator->getError());
        }
        
        /**
         * @var DataHandlerService $dataHandler
         */
        $dataHandler = $di->get('address::dataHandlerService');
        $row = $dataHandler->getRowById($param);

        $this->setBody($di->get('address::prepareResponseService')->responseGet($row));
    }

    /**
     * @param $param
     */
    public function putAction($param)
    {

    }

    /**
     * @param $param
     */
    public function postAction($param)
    {

    }

    /**
     * @param $name
     */
    public function deleteAction($name)
    {

    }
}
