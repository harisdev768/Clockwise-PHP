<?php
namespace App\Modules\User\Models;

class UserSearchFilter
{
    private ?string $keyword = null;
    private ?int $locationId = null;
    private ?int $jobRoleId = null;
    private ?int $departmentId = null;

    public function setKeyword(string $keyword): void
    {
        $this->keyword = $keyword;
    }

    public function setLocationId(?int $locationId): void
    {
        $this->locationId = $locationId;
    }

    public function setJobRoleId(?int $jobRoleId): void
    {
        $this->jobRoleId = $jobRoleId;
    }

    public function setDepartmentId(?int $departmentId): void
    {
        $this->departmentId = $departmentId;
    }

    public function getKeyword(): ?string {
        return $this->keyword;
    }

    public function getLocationId(): ?int {
        return $this->locationId;
    }

    public function getJobRoleId(): ?int {
        return $this->jobRoleId;
    }

    public function getDepartmentId(): ?int {
        return $this->departmentId;
    }

    public function isEmpty(): bool {
        return empty($this->keyword)
            && empty($this->locationId)
            && empty($this->jobRoleId)
            && empty($this->departmentId);
    }
}

