<?php
spl_autoload_register(function($class) {

        $prefix = 'My\\';

        $base_dir = __DIR__.'/../';
        $base_dir .=  strcasecmp(substr($class, -4), 'Test') ? 'src/' : 'test/';

        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }

        $relative_class = substr($class, $len);

        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

        if (file_exists($file)) {
            require $file;
        }
});