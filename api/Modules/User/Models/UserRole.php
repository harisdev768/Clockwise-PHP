<?php

namespace App\Modules\User\Models;

class UserRole {

    private int $roleId;
    private string $roleName;

    private array $roles = [
        1 => "Manager",
        2 => "Employee"
    ];

    public function __construct(int $roleId){
        $this->roleId = $roleId;
        $this->roleName = $this->roles[$roleId] ?? 'Unknown';
    }
    public function getRoleId(): int {
        return $this->roleId;
    }
    public function getRoleName(): string { return $this->roleName; }
}
