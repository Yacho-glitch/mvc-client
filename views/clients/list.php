<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get clients data passed from controller
$clients = $clients ?? [];

// Get flash message if exists
$flashMessage = $_SESSION['flash'] ?? null;
if (isset($_SESSION['flash'])) {
    unset($_SESSION['flash']);
}

// Get error message if exists
$errorMessage = $_SESSION['error'] ?? null;
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .actions a { margin-right: 5px; }
        .table { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Gestion des Clients</h1>
        <hr>

        <?php if ($flashMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($flashMessage) ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <a href="index.php?action=create" class="btn btn-primary mb-3">➕ Ajouter un client</a>

        <?php if (empty($clients)): ?>
            <div class="alert alert-info">Aucun client trouvé</div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars($client['nom'] ?? '') ?></td>
                            <td><?= htmlspecialchars($client['ville'] ?? '') ?></td>
                            <td><?= htmlspecialchars($client['tel'] ?? '') ?></td>
                            <td><?= htmlspecialchars($client['email'] ?? '') ?></td>
                            <td class="actions">
                                <a href="index.php?action=edit&id=<?= $client['id'] ?>" class="btn btn-sm btn-warning">✏️</a>
                                <a href="index.php?action=delete&id=<?= $client['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">🗑️</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>