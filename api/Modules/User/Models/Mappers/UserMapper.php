<?php
namespace App\Modules\User\Models\Mappers;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\User;
use App\Config\DB;
use App\Modules\User\Models\Collections\UserCollection;
use App\Modules\User\Models\UserId;
use App\Modules\User\Models\UserSearchFilter;

use PDO;

class UserMapper
{
    private PDO $pdo;

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

    public function findByIdentifier(User $user): User
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users
            WHERE email = :email OR username = :username
        ");
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();
    }

    public function checkEmail(User $user): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->execute();

        if ((int)$stmt->fetchColumn() > 0) {
            throw UserException::emailExists();
        }
        return true;
    }

    public function checkUsername(User $user): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->execute();

        if ((int)$stmt->fetchColumn() > 0) {
            throw UserException::userExists();
        }
        return true;
    }

    public function addUser(User $user)
    {
        $fields = [
            'first_name'  => $user->getFirstName(),
            'last_name'   => $user->getLastName(),
            'email'       => $user->getEmail(),
            'username'    => $user->getUsername(),
            'role_id'     => $user->getRole()->getRoleId(),
            'created_by'  => $user->getCreatedBy(),
        ];

        if (!empty($user->getPasswordHash())) {
            $fields['password_hash'] = $user->getPasswordHash();
        }
        if (!empty($user->getLocation()->getLocationId())) {
            $fields['location_id'] = $user->getLocation()->getLocationId();
        }
        if (!empty($user->getDepartment()->getDepartmentId())) {
            $fields['department_id'] = $user->getDepartment()->getDepartmentId();
        }
        if (!empty($user->getJobRole()->getJobRoleId())) {
            $fields['job_role_id'] = $user->getJobRole()->getJobRoleId();
        }
        if (!empty($user->getAddress())) {
            $fields['address'] = $user->getAddress();
        }
        if (!empty($user->getCellPhone())) {
            $fields['cell_phone'] = $user->getCellPhone();
        }
        if (!empty($user->getHomePhone())) {
            $fields['home_phone'] = $user->getHomePhone();
        }
        if (!empty($user->getNickname())) {
            $fields['nickname'] = $user->getNickname();
        }
        if (!empty($user->getStatus())) {
            $fields['status'] = $user->getStatus();
        }

        $columns      = array_keys($fields);
        $placeholders = array_map(fn ($c) => ':' . $c, $columns);

        $sql = "INSERT INTO users (" . implode(', ', $columns) . ")
                VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);

        foreach ($fields as $col => $val) {
            $type = match ($col) {
                'role_id', 'created_by', 'location_id', 'department_id', 'job_role_id', 'status' => PDO::PARAM_INT,
                default => PDO::PARAM_STR
            };
            $stmt->bindValue(':' . $col, $val, $type);
        }

        $stmt->execute();
        $recentId = $this->pdo->lastInsertId();

        return self::findById(new UserId($recentId));
    }

    public function getUser(User $user): ?User
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users
            WHERE email = :email OR username = :username
        ");
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : null;
    }

    public function getUsers(): UserCollection
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE deleted = 0");
        $stmt->execute();
        $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $userCollection = new UserCollection();
        foreach ($rows as $row) {
            $userCollection->add(UserHydrator::hydrateForCollection($row));
        }

        return $userCollection;
    }

    public function getUsersWithParam(UserSearchFilter $filter): UserCollection
    {
        $sql    = "SELECT * FROM users WHERE deleted = 0";
        $params = [];
        $types  = [];

        $keyword = $filter->getKeyword();
        if (!empty($keyword)) {
            $keyword = trim($keyword);
            if ($keyword !== '') {
                $sql .= " AND (username LIKE :kw
                        OR first_name LIKE :kw
                        OR last_name LIKE :kw)";
                $params[':kw'] = '%' . $keyword . '%';
                $types[':kw']  = PDO::PARAM_STR;
            }
        }

        $locationId = $filter->getLocationId();
        if (!empty($locationId)) {
            $sql .= " AND location_id = :location_id";
            $params[':location_id'] = (int)$locationId;
            $types[':location_id']  = PDO::PARAM_INT;
        }

        $departmentId = $filter->getDepartmentId();
        if (!empty($departmentId)) {
            $sql .= " AND department_id = :department_id";
            $params[':department_id'] = (int)$departmentId;
            $types[':department_id']  = PDO::PARAM_INT;
        }

        $jobRoleId = $filter->getJobRoleId();
        if (!empty($jobRoleId)) {
            $sql .= " AND job_role_id = :job_role_id";
            $params[':job_role_id'] = (int)$jobRoleId;
            $types[':job_role_id']  = PDO::PARAM_INT;
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $name => $value) {
            $stmt->bindValue($name, $value, $types[$name] ?? PDO::PARAM_STR);
        }
        $stmt->execute();

        $rows  = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        $userCollection = new UserCollection();
        foreach ($rows as $row) {
            $userCollection->add(UserHydrator::hydrateForCollection($row));
        }

        return $userCollection;
    }

    public function findByEmail(User $user): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : $user;
    }

    public function findById(UserId $userId): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindValue(':id', $userId->getUserIdVal(), PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();
    }

    public function existingCredentials(User $user)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM users
            WHERE (email = :email OR username = :username) AND id != :id
        ");
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? UserHydrator::hydrateFromArray($row) : new User();
    }

    public function updateUser(User $user)
    {
        $fields = [
            'first_name'    => $user->getFirstName(),
            'last_name'     => $user->getLastName(),
            'email'         => $user->getEmail(),
            'username'      => $user->getUsername(),
            'role_id'       => $user->getRole()->getRoleId(),
            'status'        => $user->getStatus(),
            'location_id'   => $user->getLocation()->getLocationId(),
            'department_id' => $user->getDepartment()->getDepartmentId(),
            'job_role_id'   => $user->getJobRole()->getJobRoleId(),
        ];

        if (!empty($user->getAddress())) {
            $fields['address'] = $user->getAddress();
        }
        if (!empty($user->getCellPhone())) {
            $fields['cell_phone'] = $user->getCellPhone();
        }
        if (!empty($user->getHomePhone())) {
            $fields['home_phone'] = $user->getHomePhone();
        }
        if (!empty($user->getNickname())) {
            $fields['nickname'] = $user->getNickname();
        }
        if (!empty($user->getPasswordHash())) {
            $fields['password_hash'] = $user->getPasswordHash();
        }

        $setClauses = [];
        foreach (array_keys($fields) as $col) {
            $setClauses[] = "$col = :$col";
        }

        $sql = "UPDATE users SET " . implode(', ', $setClauses) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        foreach ($fields as $col => $val) {
            $type = match ($col) {
                'role_id', 'status', 'location_id', 'department_id', 'job_role_id' => PDO::PARAM_INT,
                default => PDO::PARAM_STR
            };
            $stmt->bindValue(':' . $col, $val, $type);
        }

        $stmt->bindValue(':id', $user->getUserId(), PDO::PARAM_INT);

        $success = $stmt->execute();
        return $success ? $user : new User();
    }
}
