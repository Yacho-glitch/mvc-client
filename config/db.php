<?php
declare(strict_types=1);

session_start();

// Environment configuration
define('ENVIRONMENT', 'development'); // Change to 'production' in live

// Error reporting
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Database configuration
$dbOptions = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=mvc_clients;charset=utf8mb4',
        'root',
        '',
        $dbOptions
    );
    // echo 'Database is connected';
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    if (ENVIRONMENT === 'development') {
        die('Database connection failed: ' . $e->getMessage());
    } else {
        die('Database connection failed. Please try again later.');
    }
}

// CSRF Protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}