<?php
namespace App\Modules\User\Models\Collections;

use App\Modules\User\Models\User;
class UserCollection
{
    private array $users = [];

    public function __construct(array $users = [])
    {
        foreach ($users as $user) {
            $this->add($user);
        }
    }

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
                'status'     => $user->getStatus() ?? null,
                'created_at' => $user->getCreatedAt() ?? null,
                'role'       => $user->getRole()->getRoleName() ?? null,
            ];
        }, $this->users);
    }

    public function all(): array
    {
        return $this->users;
    }
}
