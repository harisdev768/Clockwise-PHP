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

    public function updateUser(int $userId, array $data): array
    {
        $userModel = $this->userRepository->findById($userId);
        if (!$userModel) {
            throw UserException::notFound("User not found");
        }

        $userModel->first_name = $data['first_name'];
        $userModel->last_name = $data['last_name'];
        $userModel->email = $data['email'];
        $userModel->role = $data['role'] ?? $userModel->role;

        $this->userRepository->save($userModel);

        return $userModel->toArray();
    }


}