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
        $items = array_map([self::class, 'hydrateDepartmentForCollection'], $rows);
        return new DepartmentCollection($items);
    }

    public static function hydrateJobRoleForCollection(array $data): UserJobRole
    {
        $jobRole = new UserJobRole((int) $data['id']);

        return $jobRole;
    }

    public static function hydrateJobRoleListForCollection(array $rows): JobRoleCollection
    {
        $items = array_map([self::class, 'hydrateJobRoleForCollection'], $rows);
        return new JobRoleCollection($items);
    }

    public static function hydrateLocationForCollection(array $data): UserLocation
    {
        $location = new UserLocation((int) $data['id']);
        return $location;
    }

    public static function hydrateLocationListForCollection(array $rows): LocationCollection
    {
        $items = array_map([self::class, 'hydrateLocationForCollection'], $rows);
        return new LocationCollection($items);
    }
}
