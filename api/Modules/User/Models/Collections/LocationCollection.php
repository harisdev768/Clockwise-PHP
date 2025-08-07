<?php
namespace App\Modules\User\Models\Collections;

use App\Modules\User\Models\UserLocation;

class LocationCollection
{
    private array $locations = [];

    public function __construct(array $locations = [])
    {
        foreach ($locations as $location) {
            $this->add($location);
        }
    }

    public function add(UserLocation $location): void
    {
        $this->locations[] = $location;
    }

    public function toArray(): array
    {
        return array_map(function (UserLocation $location) {
            return [
                'id'   => $location->getLocationId(),
                'name' => $location->getLocationName(),
            ];
        }, $this->locations);
    }

    public function all(): array
    {
        return $this->locations;
    }
}
