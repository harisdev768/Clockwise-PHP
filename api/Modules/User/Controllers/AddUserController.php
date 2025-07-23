<?php
namespace App\Modules\User\Controllers;

use App\Modules\User\Models\User;
use App\Modules\User\UseCases\AddUserUseCase;
use App\Modules\User\Request\AddUserRequest;

class AddUserController
{
    private AddUserUseCase $useCase;

    public function __construct(AddUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle($data): void
    {
        $this->useCase->execute(new AddUserRequest($data) );
    }
}
