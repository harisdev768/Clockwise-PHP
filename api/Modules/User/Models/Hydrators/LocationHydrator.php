<?php
namespace App\Modules\User\Models\Hydrators;

use App\Modules\User\Models\UserLocation;

class LocationHydrator
{
    public static function hydrate(array $data): UserLocation
    {
        $location = new UserLocation((int)$data['id']);

        return $location;
    }
}