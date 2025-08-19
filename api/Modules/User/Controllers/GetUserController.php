<?php
namespace App\Modules\User\Controllers;

use App\Modules\User\Request\GetUserRequest;
use App\Modules\User\UseCases\GetUserUseCase;

class GetUserController{
    private GetUserUseCase $useCase;

    public function __construct(GetUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle($data): void
    {
        $this->useCase->execute( new GetUserRequest($data) );
    }
}
