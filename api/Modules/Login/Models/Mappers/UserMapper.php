<?php
namespace App\Modules\Login\Models\Mappers;

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
        $stmt->bindParam(':identifier', $identifier);
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

        $stmt->bindParam(':ts', $nowUtc);
        $stmt->bindValue(':id', $user->getUserID()->getUserIdVal(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function findByEmail(User $user): ?User {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE email = :email
        ");

        $email = $user->getEmail();
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user;
    }

    public function findByUserName(User $user): ?User {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users 
            WHERE username = :username
        ");

        $username = $user->getUsername();
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user;
    }

    public function updatePasswordByEmail(string $email, string $hashedPassword): void {
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET password_hash = :password 
            WHERE email = :email
        ");

        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
}
