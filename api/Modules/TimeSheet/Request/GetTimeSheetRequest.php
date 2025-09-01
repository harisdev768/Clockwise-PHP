<?php

namespace App\Modules\TimeSheet\Request;

use App\Modules\TimeSheet\Exceptions\TimeSheetException;

class GetTimeSheetRequest
{
    private $data;
    private ?string $keyword;
    private ?int $locationId;
    private ?int $jobRoleId;
    private ?int $departmentId;
    private ?string $startDate;
    private ?string $endDate;


    public function __construct($data)
    {
        $this->data = $data;
        $this->keyword = $data['keyword'] ?? null;
        $this->locationId = isset($data['location_id']) ? (int)$data['location_id'] : null;
        $this->jobRoleId = isset($data['job_role_id']) ? (int)$data['job_role_id'] : null;
        $this->departmentId = isset($data['department_id']) ? (int)$data['department_id'] : null;
        $this->startDate = $data['start_date'] ?? null;
        $this->endDate = $data['end_date'] ?? null;
    }


    public function all(): array
    {
        return $this->data;
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

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate ? new \DateTime($this->startDate) : null;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate ? new \DateTime($this->endDate) : null;
    }
}