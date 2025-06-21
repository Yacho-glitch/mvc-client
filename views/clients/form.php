<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get client data passed from controller
$client = $client ?? [];

// Get error message if exists
$errorMessage = $_SESSION['error'] ?? null;
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}

// CSRF token
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($client['id']) ? 'Modifier' : 'Créer' ?> Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container { max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><?= isset($client['id']) ? 'Modifier' : 'Créer' ?> un Client</h1>
        <hr>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                <div class="form-group">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" class="form-control" id="nom" name="nom" 
                           value="<?= htmlspecialchars($client['nom'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" 
                           value="<?= htmlspecialchars($client['adresse'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" 
                           value="<?= htmlspecialchars($client['ville'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="tel" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="tel" name="tel" 
                           value="<?= htmlspecialchars($client['tel'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($client['email'] ?? '') ?>">
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="index.php?action=index" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>