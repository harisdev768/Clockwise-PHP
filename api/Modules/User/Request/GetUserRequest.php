<?php
namespace App\Modules\User\Request;

use App\Modules\User\Exceptions\UserException;

class GetUserRequest{
    private $data;
    private ?string $keyword;
    private ?int $locationId;
    private ?int $jobRoleId;
    private ?int $departmentId;
    public function __construct($data){
        $this->data = $data;
        $this->keyword = $data['keyword'] ?? null;
        $this->locationId = isset($data['location_id']) ? (int)$data['location_id'] : null;
        $this->jobRoleId = isset($data['job_role_id']) ? (int)$data['job_role_id'] : null;
        $this->departmentId = isset($data['department_id']) ? (int)$data['department_id'] : null;
    }


    public function all(): array{
        return $this->data;
    }
    public function getKeyword(): ?string{
        return $this->keyword;
    }
    public function getLocationId(): ?int{
        return $this->locationId;
    }
    public function getJobRoleId(): ?int{
        return $this->jobRoleId;
    }
    public function getDepartmentId(): ?int{
        return $this->departmentId;
    }

}