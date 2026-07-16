<?php
session_start();

require_once("config/db_connection.php");
require_once("config/config.php");
require_once('assets/template.php');

spl_autoload_register(function ($class) {
    $paths = [
        'classes/',
        'page_controller/'
    ];

    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.class.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
?>