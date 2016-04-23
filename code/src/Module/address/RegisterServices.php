<?php

namespace My\Module\address;

use App\App;
use My\Di\DI;
use My\CsvDataHandler\Writer;
use App\RegisterServicesInterface;
use My\Module\address\Service\DataHandlerService;
use My\Module\address\Service\PrepareResponseService;
use My\CsvDataHandler\Reader;
use My\Module\address\Validator\IdValidator;
use My\Module\address\Validator\RequestBodyCollectionValidator;
use My\Module\address\Validator\RequestBodyElementValidator;


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

        $di->set('address::bodyElementValidator', function () {
            return new RequestBodyElementValidator();
        });

        $di->set('address::bodyCollectionValidator', function () {
            return new RequestBodyCollectionValidator();
        });

        $di->set('address::dataHandlerService', function() use ($di) {
            $fileDataSource = $di->get('config')->get('dataFile');
                
            return new DataHandlerService(
                new Reader($fileDataSource),
                new Writer($fileDataSource)
            );
        });
        
        $di->set('address::prepareResponseService', function() {
            return new PrepareResponseService();
        });
    }
}