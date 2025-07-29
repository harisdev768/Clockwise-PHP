<?php

namespace App\Modules\User\Models;

class UserJobRole {

    private int $jobRoleId;
    private string $jobRoleName;

    private array $jobRoles = [
        1 => "Manager",
        2 => "HR",
        3 => "Software Engineer",
        4 => "Product Honor",
        5 => "Intern",
        6 => "SQA",
        7 => "Team Lead",
        8 => "Department Head"
    ];

    public function __construct(int $jobRoleId){
        $this->jobRoleId = $jobRoleId;
        $this->jobRoleName = $this->jobRoles[$jobRoleId] ?? 'Unknown';
    }

    public function getJobRoleId(): int {
        return $this->jobRoleId;
    }

    public function getJobRoleName(): string {
        return $this->jobRoleName;
    }
}
