<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Request\EditUserRequest;
use App\Modules\User\UseCases\EditUserUseCase;

class EditUserController
{
    private EditUserUseCase $useCase;

    public function __construct(EditUserUseCase $useCase)
    {
        $this->useCase = $useCase;
    }
    public function handle($data): void
    {
        $this->useCase->execute(new EditUserRequest($data));
    }
}
