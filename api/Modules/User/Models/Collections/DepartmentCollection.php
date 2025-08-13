<?php

namespace App\Modules\User\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\User\Models\UserDepartment;

class DepartmentCollection extends AbstractCollection
{
    public function mapItemToArray($item): array
    {
        return [
            'id' => $item->getDepartmentId(),
            'name' => $item->getDepartmentName(),
        ];
    }

}
