<?php
session_start();

// Base URL configuration
define('BASE_URL', 'http://localhost/ceritainaja');

// Autoloader with debug
spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../src/' . $path . '.php';
    
    // Debug
    // error_log("Trying to load: " . $file);
    
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Debug
        // error_log("File not found: " . $file);
        throw new Exception("Class file not found: " . $file);
    }
});