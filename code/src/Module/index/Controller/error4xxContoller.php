<?php

namespace My\Module\index\Controller;

class error4xxController
{
    public function action404()
    {
        var_dump('404'); die("".__FILE__."::".__LINE__);
    }
}