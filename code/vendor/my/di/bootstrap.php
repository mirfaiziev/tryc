<?php

class Autoload
{
    /**
     * @var array
     */
    protected $classMap = [];

    /**
     * @param string $prefix
     * @param string $baseDir
     */
    public function addClassMap($prefix, $baseDir)
    {
        $this->classMap[$prefix] = $baseDir;
    }

    public function register()
    {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function loadClass($className)
    {
        foreach ($this->classMap as $prefix => $baseDir) {
            if ($this->hasPrefix($className, $prefix)) {
                $relativeClass = substr($className, strlen($prefix));

                if ($this->loadFile($relativeClass, $baseDir)) {
                    break;
                }
            }
        }
    }

    /**
     * @param string $className
     * @param string $prefix
     * @return bool
     */
    protected function hasPrefix($className, $prefix)
    {
        return strncmp($prefix, $className, strlen($prefix)) == 0;
    }

    /**
     * @param string $relativeClassName
     * @param string $baseDir
     * @return bool
     */
    protected function loadFile($relativeClassName, $baseDir)
    {
        $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClassName) . '.php';
        if (file_exists($path)) {
            require $path;
            return true;
        }

        $path = $baseDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR,
                strtolower($relativeClassName)) . '.php';

        if (file_exists($path)) {
            require $path;
            return true;
        }

        return false;
    }
}

$autoloader = new Autoload();

$autoloader->addClassMap('My\\Di\\', __DIR__ . '/../vendor/my/di/src',
]);