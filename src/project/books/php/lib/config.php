<?php
// Database connection settings
define('DB_HOST', 'mysql-container');
define('DB_NAME', 'testdb');
define('DB_USER', 'testuser');
define('DB_PASS', 'mysecret');
define('DB_CHARSET', 'utf8mb4');

// Build the DSN (Data Source Name)
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET);

// PDO Options for better error handling and security
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
]);

spl_autoload_register(function ($class) {
    $class_path = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    
    $file = dirname(__DIR__) . '/classes/' . $class_path . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
?>