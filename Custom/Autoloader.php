<?php

namespace Custom;


class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            return false;
        });
    }
}
