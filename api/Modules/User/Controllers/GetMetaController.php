<?php
namespace App\Modules\User\Controllers;

use App\Modules\User\UseCases\GetMetaUseCase;

class GetMetaController{
    private GetMetaUseCase $useCase;

    public function __construct(GetMetaUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $this->useCase->execute();
    }
}
