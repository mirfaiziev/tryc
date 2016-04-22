<?php

namespace My\Module\address;

use My\App\App;
use My\Lib\RegisterServicesInterface;

class RegisterServices implements RegisterServicesInterface
{

    public static function init()
    {
        $di = App::getInstance()->getDi();
    }
}