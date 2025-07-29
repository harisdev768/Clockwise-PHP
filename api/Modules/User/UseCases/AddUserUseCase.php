<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\User;
use App\Modules\User\Models\UserDepartment;
use App\Modules\User\Models\UserJobRole;
use App\Modules\User\Models\UserLocation;
use App\Modules\User\Models\UserRole;
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
        $user->setCreatedBy($request->getCreatedBy());

        $user->setFirstName($request->getFirstName());
        $user->setLastName($request->getLastName());
        $user->setEmail($request->getEmail());
        $user->setUsername($request->getUsername());
        $user->setNickname($request->getNickname());
        $user->setStatus($request->getStatus());
        $user->setrole( new UserRole($request->getRoleId()) );
        $user->setAddress($request->getAddress());
        $user->setCellPhone($request->getCellPhone());
        $user->setHomePhone($request->getHomePhone());
        $user->setLocation(new UserLocation($request->getLocationId()));
        $user->setDepartment(new UserDepartment($request->getDepartmentId()));
        $user->setUserJobRole(new UserJobRole($request->getJobRoleId()));
        $user->setPasswordHash($request->getPassword());

        $user = $this->service->createUser($user);

        if($user->userExists()){
            return AddUserResponse::success();
        }else{
            throw UserException::userAlreadyExists();
        }
    }
}
