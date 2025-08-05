<?php
namespace App\Modules\User\Models\Collections;

use App\Modules\User\Models\User;
class UserCollection
{
    private array $users = [];

    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    /**
     * Returns array of hydrated users
     */
    public function toArray(): array
    {
        return array_map(function (User $user) {
            return [
                'id'         => $user->getUserId(),
                'first_name' => $user->getFirstName(),
                'last_name'  => $user->getLastName(),
                'email'      => $user->getEmail(),
                'username'   => $user->getUsername(),
                'nickname'   => $user->getNickname(),
                'cellphone'  => $user->getCellphone(),
                'homephone'  => $user->getHomePhone(),
                'address'    => $user->getAddress(),
                'status'     => $user->getStatus() ?? null,
                'created_at' => $user->getCreatedAt() ?? null,
                'role'       => $user->getRole()->getRoleName() ?? null,
                'role_id'    => $user->getRole()->getRoleId() ?? null,
                'delete_user' => $user->getDeleted(),
                'location'    => $user->getLocation()->getLocationId() ?? null,
                'location_name'=> $user->getLocation()->getLocationName() ?? null,
                'department'  => $user->getDepartment()->getDepartmentId() ?? null,
                'department_name'=> $user->getDepartment()->getDepartmentName() ?? null,
                'jobrole'      => $user->getJobRole()->getJobRoleId() ?? null,
                'jobrole_name' => $user->getJobRole()->getJobRoleName() ?? null,
                'last_login'   => $user->getlastLogin() ?? null,
            ];
        }, $this->users);
    }

    public function all(): array
    {
        return $this->users;
    }
}
