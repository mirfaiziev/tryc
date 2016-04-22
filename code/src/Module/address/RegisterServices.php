<?php

namespace My\Module\address;

use My\App\App;
use My\Lib\CsvDataHandler\Writer;
use My\Lib\DI;
use My\Lib\RegisterServicesInterface;
use My\Module\address\Service\DataHandlerService;
use My\Module\address\Validator\IncomingDataValidator;
use My\Lib\CsvDataHandler\Reader;


class RegisterServices implements RegisterServicesInterface
{

    public static function init()
    {
        /**
         * @var DI
         */
        $di = App::getInstance()->getDi();

        $di->set('address::incomingDataValidator', function($param) {
            return new IncomingDataValidator($param);
        });

        $di->set('address::dataHandlerService', function($fileDataSource) {
           return new DataHandlerService(
               new Reader($fileDataSource),
               new Writer($fileDataSource)
           );
        });
    }
}