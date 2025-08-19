<?php
namespace App\Modules\User\Models\Hydrators;

use App\Modules\User\Models\UserJobRole;

class JobRoleHydrator{
    public static function hydrate(array $data): UserJobRole
    {
        $jobRole = new UserJobRole((int) $data['id']);

        return $jobRole;
    }
}