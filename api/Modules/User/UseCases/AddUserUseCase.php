<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\User;
use App\Modules\User\Response\AddUserResponse;
use App\Modules\User\Services\UserService;
use App\Modules\User\Request\AddUserRequest;

class AddUserUseCase
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function execute(AddUserRequest $request): AddUserResponse    {

        $user = new User();
        $user->setFirstName($request->getFirstName());
        $user->setLastName($request->getLastName());
        $user->setEmail($request->getEmail());
        $user->setUsername($request->getUsername());
        $user->setPasswordHash($request->getPassword());
        $user = $this->service->createUser($user);


        if($user->userExists()){
            return AddUserResponse::success();
        }
        throw UserException::userNotAdded();
    }
}
