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
    public static function hydrateLocationForCollection(array $data): UserLocation
    {
        $location = new UserLocation((int) $data['id']);

        return $location;
    }

}
