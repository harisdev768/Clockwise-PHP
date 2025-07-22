<?php

namespace App\Modules\User\Models;

class UserDepartment {

    private int $departmentId;
    private string $departmentName;

    private array $departments = [
        1 => 'R&D',
        2 => 'Sales',
        3 => 'QA',
        4 => 'Customer Support',
        5 => 'Finance'
    ];

    public function __construct(int $departmentId){
        $this->departmentId = $departmentId;
        $this->departmentName = $this->departments[$departmentId] ?? 'Unknown';
    }

    public function getDepartmentId(): int {
        return $this->departmentId;
    }

    public function getDepartmentName(): string {
        return $this->departmentName;
    }
}
