<?php
namespace App\Modules\User\Models\Collections;

use App\Modules\User\Models\UserDepartment;

class DepartmentCollection
{
    private array $departments = [];

    public function add(UserDepartment $department): void
    {
        $this->departments[] = $department;
    }

    public function toArray(): array
    {
        return array_map(function (UserDepartment $department) {
            return [
                'id'   => $department->getDepartmentId(),
                'name' => $department->getDepartmentName(),
            ];
        }, $this->departments);
    }
   public function all(): array
    {
        return $this->departments;
    }
}
