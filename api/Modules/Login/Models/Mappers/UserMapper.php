<?php
namespace App\Modules\Login\Models\Mappers;

use App\Modules\Login\Models\UserID;
use PDO;
use App\Modules\Login\Models\Hydrators\UserHydrator;
use App\Modules\Login\Models\User;

class UserMapper {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByIdentifier(User $user): ?User {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE email = :identifier OR username = :identifier
        ");

        $identifier = $user->getIdentifier();
        $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user;
    }

    public function findByEmail(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");

        $stmt->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user;
    }

    public function updateLastLogin(User $user): void {
        $nowUtc = (new \DateTimeImmutable('now', new \DateTimeZone('UTC')))
            ->format('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET last_login = :ts 
            WHERE id = :id
        ");

        $stmt->bindValue(':ts', $nowUtc, PDO::PARAM_STR);
        $stmt->bindValue(':id', $user->getUserID()->getUserIdVal(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findByUserName(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindValue(':username', $user->getUsername(), PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user;
    }

    public function updatePasswordByEmail(string $email, string $hashedPassword): void {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET password_hash = :password_hash 
            WHERE email = :email
        ");

        $stmt->bindValue(':password_hash', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    }
}
