<?php
namespace App\Modules\User\Controllers;

use App\Modules\User\UseCases\GetUserUseCase;

class GetUserController{
    private GetUserUseCase $useCase;

    public function __construct(GetUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $this->useCase->execute();
    }
}
