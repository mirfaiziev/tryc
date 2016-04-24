<?php

namespace My\Module\address;

use App\App;
use My\CsvDataHandler\FileStorage;
use My\Di\DI;
use My\CsvDataHandler\Writer;
use App\RegisterServicesInterface;
use My\Module\address\Service\DataHandlerService;
use My\Module\address\Service\PrepareResponseService;
use My\CsvDataHandler\Reader;
use My\Module\address\Validator\IdValidator;
use My\Module\address\Validator\RequestBodyCollectionValidator;
use My\Module\address\Validator\RequestBodyElementValidator;
use My\Module\address\Validator\RequestBodyJsonValidator;


class RegisterServices implements RegisterServicesInterface
{

    public static function init()
    {
        /**
         * @var DI
         */
        $di = App::getInstance()->getDi();

        $di->set('address::idValidator', function () {
            return new IdValidator();
        });

        $di->set('address::bodyJsonValidator', function () {
            return new RequestBodyJsonValidator();
        });

        $di->set('address::bodyElementValidator', function () {
            return new RequestBodyElementValidator();
        });

        $di->set('address::bodyCollectionValidator', function () use ($di) {
            $validator = new RequestBodyCollectionValidator();
            $validator->setBodyElementValidator($di->get('address::bodyElementValidator'));
            return $validator;
        });

        $di->set('address::dataHandlerService', function() use ($di) {
            $fileDataSource = $di->get('config')->get('dataFile');
            $storage = new FileStorage($fileDataSource);
            return new DataHandlerService(
                new Reader($storage),
                new Writer($storage)
            );
        });
        
        $di->set('address::prepareResponseService', function() {
            return new PrepareResponseService();
        });
    }
}