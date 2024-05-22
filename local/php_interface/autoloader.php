<?php
spl_autoload_register(function($class) {
    $classPath = preg_replace('/\\\|\//', DIRECTORY_SEPARATOR, $class);

    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/local/lib/'.$classPath.'.php'))
    {
        include $_SERVER['DOCUMENT_ROOT'].'/local/lib/'.$classPath.'.php';
    }
});
