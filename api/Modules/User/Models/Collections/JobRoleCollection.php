<?php

namespace App\Modules\User\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\User\Models\UserJobRole;

class JobRoleCollection extends AbstractCollection
{
    public function mapItemToArray($item): array
    {
        return [
            'id' => $item->getJobRoleId(),
            'name' => $item->getJobRoleName(),
        ];
    }

}
