<?php

namespace App\Modules\User\Models\Hydrators;

use App\Modules\User\Models\UserDepartment;
use App\Modules\User\Models\UserJobRole;
use App\Modules\User\Models\UserLocation;
use App\Modules\User\Models\Collections\DepartmentCollection;
use App\Modules\User\Models\Collections\JobRoleCollection;
use App\Modules\User\Models\Collections\LocationCollection;

class MetaHydrator
{

    public static function hydrateDepartmentForCollection(array $data): UserDepartment
    {
        $department = new UserDepartment((int) $data['id']);
        return $department;
    }

    public static function hydrateDepartmentListForCollection(array $rows): DepartmentCollection
    {
        $departments = new DepartmentCollection();
        foreach ($rows as $department) {
            $departments->add($department);
        }
        return $departments;
    }

    public static function hydrateJobRoleForCollection(array $data): UserJobRole
    {
        $jobRole = new UserJobRole((int) $data['id']);

        return $jobRole;
    }

    public static function hydrateJobRoleListForCollection(array $rows): JobRoleCollection
    {
        $jobRoles = new JobRoleCollection();
        foreach ($rows as $jobRole) {
            $jobRoles->add($jobRole);
        }
        return $jobRoles;
    }

    public static function hydrateLocationForCollection(array $data): UserLocation
    {
        $location = new UserLocation((int) $data['id']);
        return $location;
    }

    public static function hydrateLocationListForCollection(array $rows): LocationCollection
    {
        $locations = new LocationCollection();
        foreach ($rows as $location) {
            $locations->add($location);
        }
        return $locations;
    }
}
