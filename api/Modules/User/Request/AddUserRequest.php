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

    public string $nickname;
    public int $department;
    public int $location;
    public int $jobrole;
    public int $status;
    public string $cellPhone;
    public string $homePhone;
    public string $address;


    public function __construct(array $data)
    {
        $this->firstName = trim($data['first_name']);
        $this->lastName = trim($data['last_name']);
        $this->email = trim($data['email']);
        $this->username = trim($data['username']);
        $this->created_by = trim($data['created_by']);
        $this->role_id = trim($data['role_id']);
        $this->password = trim($data['password']);
        if(!empty($this->password)){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        $this->nickname = trim($data["nickname"]);
        $this->status = trim($data["status"]);
        $this->address = ($data["address"]);
        $this->cellPhone = trim($data["cellphone"]);
        $this->homePhone = trim($data["homephone"]);
        $this->locationId = (int) $data["location"];
        $this->departmentId = (int) $data["department"];
        $this->jobRoleId = (int) $data["jobrole"];

    }
    public function getNickname(): string{
        return $this->nickname;
    }
    public function getDepartmentId(): int{
        return $this->departmentId;
    }
    public function getLocationId(): int{
        return $this->locationId;
    }
    public function getJobRoleId(): int{
        return $this->jobRoleId;
    }
    public function getStatus(): int{
        return $this->status;
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
