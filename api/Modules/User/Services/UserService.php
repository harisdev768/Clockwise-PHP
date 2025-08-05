<?php

namespace App\Modules\User\Services;


use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\Mappers\UserMapper;
use App\Modules\User\Models\User;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\UserId;

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
        $userRes = $this->mapper->findByIdentifier($user);

        if( $userRes->userExists() ) { //use userExists()
            return new User();
        } else {
            $newUser =  $this->mapper->addUser($user);
            return $newUser;
        }

    }

    public function getAllUsers()
    {
        return $this->mapper->getUsers();
    }

    public function editUser(User $user){

        $checkUser = $this->mapper->findById( new UserId($user->getUserId()) );

        if ( !$checkUser->userExists() ) {
            throw UserException::notFound();
        }

        $existingCredentials = $this->mapper->existingCredentials($user);
        if ($existingCredentials->userExists()) {
            throw UserException::userAlreadyExists();
        }

        $updateUser = $this->mapper->updateUser($user);
        return $updateUser;
    }

}