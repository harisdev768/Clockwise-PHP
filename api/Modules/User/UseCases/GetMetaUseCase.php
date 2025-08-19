<?php
namespace App\Modules\User\UseCases;

use App\Modules\User\Exceptions\MetaException;
use App\Modules\User\Services\MetaService;
use App\Modules\User\Response\GetMetaResponse;

class GetMetaUseCase{

    private MetaService $userService;
    public function __construct(MetaService $userService){
        $this->userService = $userService;
    }

    public function execute(){

        $departments = $this->userService->getAllDepartments();
        $jobroles = $this->userService->getAllJobRoles();
        $locations = $this->userService->getAllLocations();

        if ($departments->all() && $jobroles->all() && $locations->all() ) {

            $departments = $departments->toArray();
            $jobroles = $jobroles->toArray();
            $locations = $locations->toArray();

            return GetMetaResponse::success($departments, $jobroles, $locations);

        } else {
            throw MetaException::notFound();
        }
    }

}