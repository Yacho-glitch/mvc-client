<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Client.php';

class ClientController
{
    public static function index(PDO $pdo): void
    {
        try {
            $clients = Client::all($pdo);
            $flashMessage = $_SESSION['flash'] ?? null;
            unset($_SESSION['flash']);
            
            include __DIR__ . '/../views/clients/list.php';
        } catch (Exception $e) {
            self::handleError($e);
        }
    }

    public static function create(PDO $pdo): void
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                Client::create($pdo, $_POST);
                $_SESSION['flash'] = 'Client created successfully';
                header('Location: index.php?action=index');
                exit;
            }
            
            $client = [];
            include __DIR__ . '/../views/clients/form.php';
        } catch (Exception $e) {
            self::handleError($e, 'create');
        }
    }

    public static function edit(PDO $pdo, int $id): void
    {
        try {
            $client = Client::find($pdo, $id);
            
            if (!$client) {
                throw new RuntimeException("Client not found");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                Client::update($pdo, $id, $_POST);
                $_SESSION['flash'] = 'Client updated successfully';
                header('Location: index.php?action=index');
                exit;
            }
            
            include __DIR__ . '/../views/clients/form.php';
        } catch (Exception $e) {
            self::handleError($e, 'edit', $id);
        }
    }
    
    public static function delete(PDO $pdo, int $id): void
    {
        try {
            if (!Client::find($pdo, $id)) {
                throw new RuntimeException("Client not found");
            }
            
            Client::delete($pdo, $id);
            $_SESSION['flash'] = 'Client deleted successfully';
            header('Location: index.php?action=index');
            exit;
        } catch (Exception $e) {
            self::handleError($e);
        }
    }
    
    private static function handleError(Exception $e, string $action = '', int $id = 0): void
    {
        error_log('Error in ClientController: ' . $e->getMessage());
        
        $_SESSION['error'] = ENVIRONMENT === 'development' 
            ? $e->getMessage() 
            : 'An error occurred. Please try again.';
        
        $redirect = $action === 'edit' && $id 
            ? "index.php?action=edit&id=$id" 
            : 'index.php?action=index';
        
        header("Location: $redirect");
        exit;
    }
}

















