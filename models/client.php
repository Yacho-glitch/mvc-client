<?php
declare(strict_types=1);

class Client 
{
    private static function validateData(array $data): array
    {
        $validated = [
            'nom' => trim($data['nom'] ?? ''),
            'adresse' => trim($data['adresse'] ?? ''),
            'ville' => trim($data['ville'] ?? ''),
            'tel' => preg_replace('/[^0-9+]/', '', $data['tel'] ?? ''),
            'email' => filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL)
        ];

        if (empty($validated['nom'])) {
            throw new InvalidArgumentException("Client name is required");
        }

        if (!empty($validated['email']) && !filter_var($validated['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format");
        }

        return $validated;
    }

    public static function all(PDO $pdo): array
    {
        try {
            return $pdo->query("SELECT * FROM client ORDER BY id DESC")->fetchAll();
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to fetch clients: " . $e->getMessage());
        }
    }

    public static function find(PDO $pdo, int $id): ?array
    {
        try {
            $stmt = $pdo->prepare("SELECT * FROM client WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch() ?: null;
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to find client: " . $e->getMessage());
        }
    }

    public static function create(PDO $pdo, array $data): int
    {
        $validated = self::validateData($data);
        
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO client (nom, adresse, ville, tel, email) 
                VALUES (:nom, :adresse, :ville, :tel, :email)"
            );
            $stmt->execute($validated);
            return (int)$pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to create client: " . $e->getMessage());
        }
    }

    public static function update(PDO $pdo, int $id, array $data): bool
    {
        $validated = self::validateData($data);
        $validated['id'] = $id;
        
        try {
            $stmt = $pdo->prepare(
                "UPDATE client SET 
                nom = :nom, 
                adresse = :adresse, 
                ville = :ville, 
                tel = :tel, 
                email = :email 
                WHERE id = :id"
            );
            return $stmt->execute($validated);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to update client: " . $e->getMessage());
        }
    }

    public static function delete(PDO $pdo, int $id): bool
    {
        try {
            $stmt = $pdo->prepare("DELETE FROM client WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new RuntimeException("Failed to delete client: " . $e->getMessage());
        }
    }
}