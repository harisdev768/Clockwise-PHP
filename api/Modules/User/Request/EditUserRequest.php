<?php
namespace App\Modules\User\Request;

use App\Modules\User\Exceptions\UserException;

class EditUserRequest
{
    private array $data;

    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $nickname;
    private int $status;
    private string $roleId;
    private bool $deleted;
    private string $password;
    private int $userId;
    private string $address;
    private string $cellPhone;
    private string $homePhone;
    private int $locationId;
    private int $departmentId;
    private int $jobRoleId;
    public function __construct($data) {
        $this->data = $data;
        $this->firstName = trim($data["first_name"]);
        $this->lastName = trim($data["last_name"]);
        $this->email = trim($data["email"]);
        $this->username = trim($data["username"]);
        $this->nickname = trim($data["nickname"]);
        $this->status = trim($data["status"]);
        $this->roleId = trim($data["role_id"]);
        $this->userId = trim($data["user_id"]);
        $this->address = ($data["address"]);
        $this->cellPhone = trim($data["cellphone"]);
        $this->homePhone = trim($data["homephone"]);
        $this->locationId = (int) $data["location"];
        $this->departmentId = (int) $data["department"];
        $this->jobRoleId = (int) $data["jobrole"];
        $this->password = $data["password"];
        if(!empty($this->password)){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

    }
    public function getFirstName(): string{
        return $this->firstName;
    }
    public function getLastName(): string{
        return $this->lastName;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function getUsername(): string{
        return $this->username;
    }
    public function getNickname(): string{
        return $this->nickname;
    }
    public function getStatus(): int{
        return $this->status;
    }
    public function getRoleId(): int{
        return $this->roleId;
    }
    public function isDeleted(): bool{
        return $this->deleted;
    }
    public function getUserId(): int{
        return $this->userId;
    }
    public function getAddress(): string{
        return $this->address;
    }
    public function getCellPhone(): string{
        return $this->cellPhone;
    }
    public function getHomePhone(): string{
        return $this->homePhone;
    }
    public function getLocationId(): int{
        return $this->locationId;
    }
    public function getDepartmentId(): int{
        return $this->departmentId;
    }
    public function getJobRoleId(): int{
        return $this->jobRoleId;
    }
    public function getPassword(): string{
        return $this->password;
    }


    public function validate(): array
    {
        if (empty($this->data['first_name']) || empty($this->data['last_name']) || empty($this->data['email'])) {
            throw UserException::missingCredentials();
        }

        if (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            throw UserException::emailFormat();
        }

        if (empty($this->data['user_id'])) {
            throw UserException::userIdMissing();
        }

        return $this->data;
    }
}
