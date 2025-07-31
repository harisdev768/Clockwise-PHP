<?php

namespace App\Modules\Login\Models\Mappers;

use PDO;

class UserTokenMapper {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function saveToken(int $userId, string $token, int $expirySeconds = 3600): void {
        // Use UTC for consistency across systems
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $issuedAt  = $now->format('Y-m-d H:i:s');
        $expiresAt = $now->modify('+' . $expirySeconds . ' seconds')->format('Y-m-d H:i:s');

        // Check if token already exists for this user
        $stmt = $this->pdo->prepare("
            SELECT token_id 
            FROM user_tokens 
            WHERE user_id = :user_id
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $query = $this->pdo->prepare("
                UPDATE user_tokens
                SET jwt_token = :token, issued_at = :issued_at, expires_at = :expires_at
                WHERE user_id = :user_id
            ");
        } else {
            $query = $this->pdo->prepare("
                INSERT INTO user_tokens (user_id, jwt_token, issued_at, expires_at)
                VALUES (:user_id, :token, :issued_at, :expires_at)
            ");
        }

        $query->bindValue(':token', $token);
        $query->bindValue(':issued_at', $issuedAt);
        $query->bindValue(':expires_at', $expiresAt);
        $query->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }
}
