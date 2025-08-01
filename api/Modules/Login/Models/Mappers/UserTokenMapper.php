<?php

namespace App\Modules\Login\Models\Mappers;

class UserTokenMapper {
    private \PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function saveToken(int $userId, string $token, int $expirySeconds = 3600): void {
        $issuedAt = date('Y-m-d H:i:s');
        $expiresAt = date('Y-m-d H:i:s', time() + $expirySeconds);

        // Check if token already exists for this user
        $stmt = $this->pdo->prepare("SELECT token_id FROM user_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        $existing = $stmt->fetch();

        if ($existing) {
            $query = $this->pdo->prepare("
                UPDATE user_tokens 
                SET jwt_token = ?, issued_at = ?, expires_at = ?
                WHERE user_id = ?
            ");
        } else {
            $query = $this->pdo->prepare("
                INSERT INTO user_tokens (user_id, jwt_token, issued_at, expires_at)
                VALUES (?, ?, ?, ?)
            ");
        }
        $query->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $query->bindValue(':token', $token);
        $query->bindValue(':issued_at', $issuedAt);
        $query->bindValue(':expires_at', $expiresAt);
        $query->execute([$token, $issuedAt, $expiresAt, $userId]);
    }
}
