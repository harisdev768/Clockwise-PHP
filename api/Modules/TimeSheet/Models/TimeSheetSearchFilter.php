<?php

namespace App\Modules\TimeSheet\Models;

class TimeSheetSearchFilter
{
    private ?string $keyword = null;
    private ?int $locationId = null;
    private ?int $jobRoleId = null;
    private ?int $departmentId = null;
    private ?\DateTime $startDate = null;
    private ?\DateTime $endDate = null;

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

    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    public function getLocationId(): ?int
    {
        return $this->locationId;
    }

    public function getJobRoleId(): ?int
    {
        return $this->jobRoleId;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function setDateRange(\DateTime $startDate, \DateTime $endDate): void
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function isEmpty(): bool
    {
        return empty($this->keyword)
            && empty($this->locationId)
            && empty($this->jobRoleId)
            && empty($this->departmentId)
            && empty($this->startDate)
            && empty($this->endDate);
    }
}

