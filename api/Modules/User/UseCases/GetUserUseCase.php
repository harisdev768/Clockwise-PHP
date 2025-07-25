<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Services\UserService;
use App\Modules\User\Response\GetUserResponse;

class GetUserUseCase{

    private UserService $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function execute(){
        $users = $this->userService->getAllUsers(); // returns UserCollection
        if ($users->all()) {
            $collection = $users->toArray();
            return GetUserResponse::success($collection); // Convert to array here
        } else {
            throw UserException::notFound();
        }
    }

}