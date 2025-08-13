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


    public static function hydrateJobRoleForCollection(array $data): UserJobRole
    {
        $jobRole = new UserJobRole((int) $data['id']);

        return $jobRole;
    }

    public static function hydrateLocationForCollection(array $data): UserLocation
    {
        $location = new UserLocation((int) $data['id']);
        return $location;
    }

}
