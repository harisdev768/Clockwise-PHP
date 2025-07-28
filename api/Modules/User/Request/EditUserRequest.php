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
    private int $status;
    private string $roleId;
    private bool $deleted;
    private int $userId;
    public function __construct($data) {
        $this->data = $data;
        $this->firstName = $data["first_name"];
        $this->lastName = $data["last_name"];
        $this->email = $data["email"];
        $this->username = $data["username"];
        $this->status = $data["status"];
        $this->roleId = $data["role_id"];
//        $this->deleted = $data["delete_user"];
        $this->userId = $data["user_id"];
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
