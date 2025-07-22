<?php

namespace App\Modules\User\Services;

use App\Config\DB;
use App\Modules\Login\Exceptions\LoginException;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\Mappers\UserMapper;
use App\Modules\User\Models\User;
use App\Modules\User\Request\AddUserRequest;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Response\AddUserResponse;

class UserService
{
    private UserHydrator $hydrator;
    private UserMapper $mapper;

    public function __construct(UserHydrator $hydrator, UserMapper $mapper)
    {
        $this->hydrator = $hydrator;
        $this->mapper = $mapper;
    }

    public function createUser(User $user): User
    {

        $checkEmail = $this->mapper->checkEmail($user);
        $checkUsername = $this->mapper->checkUsername($user);

        if($checkEmail === true && $checkUsername === true){
            $this->mapper->addUser($user);
            return $user;
        } else {
            return new User();
        }

    }
}