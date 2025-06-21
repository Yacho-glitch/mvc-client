<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure $content is defined
$content = $content ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .alert { padding: 10px 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert.error { background-color: #ffdddd; border-left: 4px solid #f44336; }
        .alert.success { background-color: #ddffdd; border-left: 4px solid #4CAF50; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Gestion des Clients</h1>
            <hr>
        </header>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert success">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
        <?php endif; ?>

        <main>
            <?php 
            // Safely include the content
            if (!empty($content) && file_exists($content)) {
                include $content;
            } else {
                echo '<div class="alert error">Content not found</div>';
            }
            ?>
        </main>

        <footer>
            <hr>
            <p>&copy; <?= date('Y') ?> Client Management System</p>
        </footer>
    </div>
</body>
</html> 

<!-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients MVC</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gestion des Clients</h1>
            <hr>
        </header>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert success">
                <?= htmlspecialchars($_SESSION['flash']) ?>
            </div>
        <?php endif; ?>

        <main>
            <!-- <?php include $content; ?> -->
        </main>

        <footer>
            <hr>
            <p>&copy; <?= date('Y') ?> Client Management System</p>
        </footer>
    </div>
</body>
</html> -->