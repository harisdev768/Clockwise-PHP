<?php
namespace App\Modules\User\Models\Mappers;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\User;
use App\Config\DB;

class UserMapper
{
    private $pdo;
    private UserHydrator $hydrator;
    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function toDatabase(User $user): array
    {
        return [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getUsername(),
            password_hash($user->getPasswordHash(), PASSWORD_BCRYPT),
        ];
    }
    public function checkEmail(User $user): bool{

        // Check for duplicate email
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$user->getEmail()]);
        if ($stmt->fetchColumn() > 0) {
            throw UserException::emailExists();
        }
        return true;
    }
    public function checkUsername(User $user): bool{

        // Check for duplicate username
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$user->getUsername()]);
        if ($stmt->fetchColumn() > 0) {
            throw UserException::userExists();
        }
        return true;
    }
    public function addUser(User $user){

        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, email, username, password_hash)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute(self::toDatabase($user));

        return $user;
    }
}
