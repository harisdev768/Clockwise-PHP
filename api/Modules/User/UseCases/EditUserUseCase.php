<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Models\UserRole;
use App\Modules\User\Models\User;
use App\Modules\User\Request\EditUserRequest;
use App\Modules\User\Response\EditUserResponse;
use App\Modules\User\Services\UserService;
use App\Modules\User\Exceptions\UserException;

class EditUserUseCase
{
    private UserService $service;
    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function execute(EditUserRequest $request): EditUserResponse
    {
        $user = new User();
        $user->setFirstName($request->getFirstName());
        $user->setLastName($request->getLastName());
        $user->setEmail($request->getEmail());
        $user->setUsername($request->getUsername());
        $user->setStatus($request->getStatus());
        $user->setrole( new UserRole($request->getRoleId()) );
        $user->setUserId($request->getUserId());

        $userRes = $this->service->editUser($user);

        if ($userRes->userExists()) {
            return EditUserResponse::success($userRes);
        }

        throw UserException::editUserFailed();
    }
}
