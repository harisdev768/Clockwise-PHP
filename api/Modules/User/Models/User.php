<?php
namespace App\Modules\User\Models;

class User
{
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $passwordHash;
    private int $createdBy;
    private string $cellPhone;
    private string $homePhone;
    private string $nickname;
    private string $address;
    private string $permissionLevel;
    private int $status;

    public function userExists(): bool{ //
        if( empty($this->firstName) ||
            empty($this->lastName) ||
            empty($this->email) ||
            empty($this->username) ||
            empty($this->passwordHash) ) {
            return false;
        } else{
            return true;
        }
    }

    public function setFirstName(string $name): void { $this->firstName = $name; }
    public function setLastName(string $name): void { $this->lastName = $name; }
    public function setEmail(string $email): void { $this->email = $email; }
    public function setUsername(string $username): void { $this->username = $username; }
    public function setPasswordHash(string $hash): void { $this->passwordHash = $hash; }
    public function setCreatedBy(int $id): void { $this->createdBy = $id; }
    public function setCellPhone(string $phone): void { $this->cellPhone = $phone; }
    public function setHomePhone(string $phone): void { $this->homePhone = $phone; }
    public function setNickname(string $nickname): void { $this->nickname = $nickname; }
    public function setAddress(string $address): void { $this->address = $address; }
    public function setPermissionLevel(int $level): void { $this->permissionLevel = $level; }
    public function setStatus(int $status): void { $this->status = $status; }

    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function getCreatedBy(): int { return $this->createdBy; }
    public function getCellPhone(): string { return $this->cellPhone; }
    public function getHomePhone(): string { return $this->homePhone; }
    public function getNickname(): string { return $this->nickname; }
    public function getAddress(): string { return $this->address; }
    public function getPermissionLevel(): int{ return $this->permissionLevel; }
    public function getStatus(): int{ return $this->status; }
}
