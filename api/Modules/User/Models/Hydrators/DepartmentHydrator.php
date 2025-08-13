<?php
namespace App\Modules\User\Models\Hydrators;

use App\Modules\User\Models\UserDepartment;

class DepartmentHydrator{
    public static function hydrate(array $data): UserDepartment
    {
        $department = new UserDepartment((int) $data['id']);
        
        return $department;
    }
}