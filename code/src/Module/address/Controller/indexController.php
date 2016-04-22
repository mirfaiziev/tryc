<?php
namespace My\Module\address\Controller;

use My\App\App;
use My\Lib\AbstractValidator;
use My\Lib\Http\Controller\AbstractController;
use My\Lib\Http\Dispatcher\ControllerRuntimeException;

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
        $validator = $di->get('address::incomingDataValidator', $param, '123');

        if (!$validator->isValid()) {
            throw new ControllerRuntimeException($validator->getError());
        }

        $reader = $di->get('dataReader', $this->config->get('dataFile'));
        $reader->read();

        if (!isset($reader->getData()[$param])) {
            throw new ControllerRuntimeException('Wrong param '.$param);
        }

        $line =  $reader->getData()[$param];
        $this->response->setBody([
            'name' => $line[0],
            'phone' => $line[1],
            'street' => $line[2],
        ]);
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
