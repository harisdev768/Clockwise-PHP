<?php
namespace App\Modules\User\Models\Mappers;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\User;
use App\Config\DB;
use App\Modules\User\Models\Collections\UserCollection;

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
            $user->getCreatedBy(),
            $user->getRole()->getRoleId(),
        ];
    }
    public function findByIdentifier(User $user): User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$user->getEmail(), $user->getUsername()]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();

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
            INSERT INTO users (first_name, last_name, email, username, password_hash, created_by, role_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute(self::toDatabase($user));

        $newUser = self::getUser($user);

        return $newUser;
    }
    public function getUser(User $user): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$user->getEmail(), $user->getUsername()]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : null;
    }

    public function getUsers(){

        $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, username, role_id, created_at, status, created_by, password_hash , deleted FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            if(!$row['deleted'] ){
                $users[] = UserHydrator::hydrateFromArray($row); // returns User model
            }
        }

        return new UserCollection($users);
    }

    public function findByEmail(User $user): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$user->getEmail()]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : $user ;
    }

    public function findById(int $id){

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();
    }



    public function existingCredentials(User $user){
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE (email = ? OR username = ?) AND id != ? ");
        $stmt->execute([$user->getEmail(), $user->getUsername(), $user->getUserId() ]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();
    }
    public function updateUser(User $user){
        $stmt = $this->pdo->prepare("
            UPDATE users 
            SET first_name = ?, last_name = ?, email = ?, username = ? , role_id = ?, status = ? , deleted = ?
            WHERE id = ?
        ");

        $success = $stmt->execute([
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getUsername(),
            $user->getRole()->getRoleId(),
            $user->getStatus(),
            $user->getDeletedToInt(),
            $user->getUserId(),
        ]);
        if($success){
            return $user;
        }else{
            return new User();
        }
    }
}
