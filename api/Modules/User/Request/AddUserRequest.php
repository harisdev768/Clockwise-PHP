<?php
namespace App\Modules\User\Request;

use App\Modules\User\Exceptions\UserException;

class AddUserRequest
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $username;
    public string $password;
    public int $created_by;
    public int $role_id;

    public function __construct(array $data)
    {
        $this->firstName = trim($data['first_name']);
        $this->lastName = trim($data['last_name']);
        $this->email = trim($data['email']);
        $this->username = trim($data['username']);
        $this->password = trim($data['password']);
        $this->created_by = trim($data['created_by']);
        $this->role_id = trim($data['role_id']);
    }

    public function getEmail(){
        return $this->email;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getCreatedBy() {
        return $this->created_by;
    }
    public function getRoleId(): int
    {
        return $this->role_id;
    }
    public function serialize(): array {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'username' => $this->username,
            'created_by' => $this->created_by,
            'role_id' => $this->role_id,
        ];
    }
}
