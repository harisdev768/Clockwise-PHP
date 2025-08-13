<?php

namespace App\Modules\User\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\User\Models\User;

class UserCollection extends AbstractCollection
{
    public function mapItemToArray($item): array
    {
        return [
            'id' => $item->getUserId(),
            'first_name' => $item->getFirstName(),
            'last_name' => $item->getLastName(),
            'email' => $item->getEmail(),
            'username' => $item->getUsername(),
            'nickname' => $item->getNickname(),
            'cellphone' => $item->getCellphone(),
            'homephone' => $item->getHomePhone(),
            'address' => $item->getAddress(),
            'status' => $item->getStatus() ?? null,
            'created_at' => $item->getCreatedAt() ?? null,
            'role' => $item->getRole()->getRoleName() ?? null,
            'role_id' => $item->getRole()->getRoleId() ?? null,
            'delete_user' => $item->getDeleted(),
            'location' => $item->getLocation()->getLocationId() ?? null,
            'location_name' => $item->getLocation()->getLocationName() ?? null,
            'department' => $item->getDepartment()->getDepartmentId() ?? null,
            'department_name' => $item->getDepartment()->getDepartmentName() ?? null,
            'jobrole' => $item->getJobRole()->getJobRoleId() ?? null,
            'jobrole_name' => $item->getJobRole()->getJobRoleName() ?? null,
            'last_login' => $item->getLastLogin() ?? null,
        ];
    }

}
