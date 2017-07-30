<?php

set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, $severity, $severity, $file, $line);
});

spl_autoload_register(function($class) {

    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class . '.php');
    if (file_exists($file))
    {
        require_once $file;
    }
    else
    {
        return false;
    }
});
