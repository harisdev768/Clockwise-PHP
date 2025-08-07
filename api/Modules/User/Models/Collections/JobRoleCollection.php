<?php
namespace App\Modules\User\Models\Collections;

use App\Modules\User\Models\UserJobRole;

class JobRoleCollection
{
    private array $jobRoles = [];

    public function __construct(array $jobRoles = [])
    {
        foreach ($jobRoles as $jobRole) {
            $this->add($jobRole);
        }
    }

    public function add(UserJobRole $jobRole): void
    {
        $this->jobRoles[] = $jobRole;
    }

    public function toArray(): array
    {
        return array_map(function (UserJobRole $jobRole) {
            return [
                'id'   => $jobRole->getJobRoleId(),
                'name' => $jobRole->getJobRoleName(),
            ];
        }, $this->jobRoles);
    }

    public function all(): array
    {
        return $this->jobRoles;
    }
}
