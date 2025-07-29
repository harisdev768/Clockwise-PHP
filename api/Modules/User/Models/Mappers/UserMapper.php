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
    public function addUser(User $user)
    {
        $columns = ['first_name', 'last_name', 'email', 'username', 'role_id', 'created_by'];
        $placeholders = ['?', '?', '?', '?', '?', '?'];
        $params = [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getUsername(),
            $user->getRole()->getRoleId(),
            $user->getCreatedBy()
        ];

        // Optional fields
        if (!empty($user->getPasswordHash())) {
            $columns[] = 'password_hash';
            $placeholders[] = '?';
            $params[] = $user->getPasswordHash();
        }

        if (!empty($user->getLocation()->getLocationId())) {
            $columns[] = 'location_id';
            $placeholders[] = '?';
            $params[] = $user->getLocation()->getLocationId();
        }

        if (!empty($user->getDepartment()->getDepartmentId())) {
            $columns[] = 'department_id';
            $placeholders[] = '?';
            $params[] = $user->getDepartment()->getDepartmentId();
        }

        if (!empty($user->getJobRole()->getJobRoleId())) {
            $columns[] = 'job_role_id';
            $placeholders[] = '?';
            $params[] = $user->getJobRole()->getJobRoleId();
        }

        if (!empty($user->getAddress())) {
            $columns[] = 'address';
            $placeholders[] = '?';
            $params[] = $user->getAddress();
        }

        if (!empty($user->getCellPhone())) {
            $columns[] = 'cell_phone';
            $placeholders[] = '?';
            $params[] = $user->getCellPhone();
        }

        if (!empty($user->getHomePhone())) {
            $columns[] = 'home_phone';
            $placeholders[] = '?';
            $params[] = $user->getHomePhone();
        }

        if (!empty($user->getNickname())) {
            $columns[] = 'nickname';
            $placeholders[] = '?';
            $params[] = $user->getNickname();
        }

        if (!empty($user->getStatus())) {
            $columns[] = 'status';
            $placeholders[] = '?';
            $params[] = $user->getStatus();
        }

        $sql = "INSERT INTO users (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        // Fetch and return the new user by email/username
        return self::getUser($user);
    }

    public function getUser(User $user): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$user->getEmail(), $user->getUsername()]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : null;
    }

    public function getUsers(){

        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            if(!$row['deleted'] ){
                $users[] = UserHydrator::hydrateForCollection($row); // returns User model
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
    public function updateUser(User $user)
    {
        $params = [
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getUsername(),
            $user->getRole()->getRoleId(),
            $user->getStatus(),
            $user->getLocation()->getLocationId(),
            $user->getDepartment()->getDepartmentId(),
            $user->getJobRole()->getJobRoleId(),
        ];

        $sql = "
        UPDATE users 
        SET first_name = ?, last_name = ?, email = ?, username = ?, role_id = ?, status = ? 
            , location_id = ?, department_id = ?, job_role_id = ? ";

        if (!empty($user->getAddress()) ) {
            $sql .= ", address = ?";
            $params[] = $user->getAddress();
        }

        if (!empty($user->getCellPhone()) ) {
            $sql .= ", cell_phone = ?";
            $params[] = $user->getCellPhone();
        }
        if (!empty($user->getHomePhone()) ) {
            $sql .= ", home_phone = ?";
        }

        if (!empty(trim($user->getAddress())) ) {
            $sql .= ", address = ?";
            $params[] = $user->getAddress();
        }

        if (!empty($user->getNickname()) ) {
            $sql .= ", nickname = ?";
            $params[] = $user->getNickname();
        }

        if (!empty($user->getPasswordHash())) {
            $sql .= ", password_hash = ?";
            $params[] = $user->getPasswordHash();
        }

        $sql .= " WHERE id = ?";
        $params[] = $user->getUserId();

        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute($params);

        return $success ? $user : new User();
    }

}
