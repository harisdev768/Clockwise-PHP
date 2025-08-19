<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Models\UserSearchFilter;
use App\Modules\User\Request\GetUserRequest;
use App\Modules\User\Services\UserService;
use App\Modules\User\Response\GetUserResponse;

class GetUserUseCase{

    private UserService $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function execute(GetUserRequest $request): GetUserResponse
    {
        $filter = new UserSearchFilter();

        if ($request->getKeyword() !== null) {
            $filter->setKeyword($request->getKeyword());
        }
        if (!empty($request->getDepartmentId())) {
            $filter->setDepartmentId((int) $request->getDepartmentId());
        }
        if ($request->getJobRoleId() !== null) {
            $filter->setJobRoleId((int) $request->getJobRoleId());
        }
        if ($request->getLocationId() !== null) {
            $filter->setLocationId((int) $request->getLocationId());
        }

        $users = !$filter->isEmpty()
            ? $this->userService->getAllUsersWithParams($filter)
            : $this->userService->getAllUsers();

            return GetUserResponse::success($users->toArray());

    }

}