<?php
session_start();

// Base URL
define('BASE_URL', 'http://localhost/ceritayuk');

// Autoloader
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../src/' . $path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);