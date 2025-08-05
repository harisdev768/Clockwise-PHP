<?php
namespace App\Modules\Login\Services;

use App\Modules\Login\Models\Mappers\UserMapper;
use App\Modules\Login\Models\User;
use App\Modules\Login\Exceptions\LoginException;

class LoginUserService {

    private UserMapper $userMapper;

    public function __construct(UserMapper $userMapper) {
        $this->userMapper = $userMapper;
    }
    public function saveLastLogin(User $user ): ?User
    {
        $userRes = $this->userMapper->saveLastLogin($user);

        if(!$userRes->userExists()) {
            return new User();
        }
        return $userRes;

    }

    public function login(User $user): ?User {

        $userRes = $this->userMapper->findByIdentifier($user);

        if (!$userRes->userExists() || !password_verify($user->getPassword(), $userRes->getPassword())) {
            throw LoginException::unauthorized();
        }
        if ($userRes->getStatus() === 0) {
            throw LoginException::deactivated();
        }

        $this->userMapper->updateLastLogin($userRes);

        return $userRes;

    }


}