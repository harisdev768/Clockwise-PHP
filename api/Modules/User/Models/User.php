<?php
namespace App\Modules\User\Models;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $nickname;
    private string $passwordHash;
    private int $createdBy;
    private mixed $createdAt;
    private string $cellPhone;
    private string $homePhone;
    private string $address;
    private string $permissionLevel;
    private int $status;
    private ?UserRole $role = null;
    private bool $deleted = false;
    private ?UserLocation $location;
    private ?UserJobRole $jobRole;
    private ?UserDepartment $department;

    private string $lastLogin;

    public function userExists(): bool{ //
        if( empty($this->id) ) {
            return false;
        } else{
            return true;
        }
    }
    public function userRequiredInfo(): bool{ //
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
    public function setNickname(string $nickname): void { $this->nickname = $nickname; }
    public function setPasswordHash(string $hash): void { $this->passwordHash = $hash; }
    public function setCreatedBy(int $id): void { $this->createdBy = $id; }
    public function setCellPhone(string $phone): void { $this->cellPhone = $phone; }
    public function setHomePhone(string $phone): void { $this->homePhone = $phone; }
    public function setAddress(string $address): void { $this->address = $address; }
    public function setPermissionLevel(int $level): void { $this->permissionLevel = $level; }
    public function setStatus(int $status): void { $this->status = $status; }
    public function setUserId(int $id): void{ $this->id = $id;}
    public function setCreatedAt($createdAt): void{ $this->createdAt = $createdAt;}
    public function setrole(UserRole $role): void{ $this->role = $role;}
    public function setLocation(UserLocation $location): void{ $this->location = $location;}
    public function setDepartment(UserDepartment $department): void{ $this->department = $department;}
    public function setUserJobRole(UserJobRole $jobRole): void{ $this->jobRole = $jobRole;}
    public function setLastLogin(string $lastLogin): void{ $this->lastLogin = $lastLogin;}
    public function setDeleted(bool $deleted): void{ $this->deleted = $deleted;}
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
    public function getUserId(): int{ return $this->id; }
    public function getCreatedAt(){ return $this->createdAt; }
    public function getRole(): ?UserRole { return $this->role; }
    public function getDepartment(): ?UserDepartment { return $this->department; }
    public function getLocation(): ?UserLocation { return $this->location; }
    public function getJobRole(): ?UserJobRole { return $this->jobRole; }
    public function getDeleted(): bool{ return $this->deleted; }
    public function getDeletedToInt(): int{ return (int) $this->deleted; }
    public function getLastLogin(): string{ return $this->lastLogin; }

}
