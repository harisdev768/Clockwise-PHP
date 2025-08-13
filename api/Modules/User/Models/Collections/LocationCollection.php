<?php

namespace App\Modules\User\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\User\Models\UserLocation;

class LocationCollection extends AbstractCollection
{
    public function mapItemToArray($item): array
    {
        return [
            'id' => $item->getLocationId(),
            'name' => $item->getLocationName(),
        ];
    }

}
