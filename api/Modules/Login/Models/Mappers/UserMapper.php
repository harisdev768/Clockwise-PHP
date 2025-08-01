<?php
namespace App\Modules\Login\Models\Mappers;

use App\Modules\Login\Models\UserID;
use PDO;

use App\Modules\Login\Models\Hydrators\UserHydrator;
use App\Modules\Login\Models\User;

class UserMapper {
    private PDO $pdo;

    public function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function findByIdentifier(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
        $stmt->execute([':email' => $user->getIdentifier(), ':username' => $user->getIdentifier()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? UserHydrator::hydrate($row) : $user ;

    }

    public function findByEmail(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $user->getEmail()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user ;

    }
    public function findByUserName(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $user->getUsername()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrate($row) : $user ;

    }
    public function updatePasswordByEmail(string $email, string $hashedPassword): void {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :password_hash WHERE email = :email");
        $stmt->execute([':password_hash' => $hashedPassword, ':email' => $email]);
    }

    public function updateLastLogin(UserID $userId): void
    {
        $sql = "UPDATE users SET last_login = UTC_TIMESTAMP() WHERE id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId->getUserIdVal()]);
    }

}