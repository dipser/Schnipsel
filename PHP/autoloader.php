<?php

/**
* Autoloader
*/
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {if ($class=='db')return false;
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
            if (file_exists(stream_resolve_include_path($file))) {
                include_once $file;
                return true;
            }
            return false;
        });
    }
}
Autoloader::register();

?>
