<?php
declare(strict_types=1);

// Start session and set base path
// session_start();
define('BASE_PATH', realpath(__DIR__ . '/..'));

// Load configuration and classes
require_once BASE_PATH . '/config/db.php';
require_once BASE_PATH . '/controllers/ClientController.php';

// Initialize CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Get and sanitize action parameter
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'index';

// Get and validate ID parameter
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// CSRF protection for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = filter_input(INPUT_POST, 'csrf_token', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$token || !hash_equals($_SESSION['csrf_token'], $token)) {
        $_SESSION['error'] = 'Invalid CSRF token';
        header('Location: index.php?action=index');
        exit;
    }
}

// Route handling
try {
    switch ($action) {
        case 'create':
            ClientController::create($pdo);
            break;
            
        case 'edit':
            if (!$id) {
                throw new InvalidArgumentException("Missing client ID");
            }
            ClientController::edit($pdo, $id);
            break;
            
        case 'delete':
            if (!$id) {
                throw new InvalidArgumentException("Missing client ID");
            }
            ClientController::delete($pdo, $id);
            break;
            
        case 'index':
        default:
            ClientController::index($pdo);
            break;
    }
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred. Please try again.';
    header('Location: index.php?action=index');
    exit;
}


