<?php
namespace App\Modules\TimeSheet\Controllers;

use App\Modules\TimeSheet\UseCases\GetTimeSheetUseCase;

class GetTimeSheetController{
    private GetTimeSheetUseCase $useCase;

    public function __construct(GetTimeSheetUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(): void
    {
        $this->useCase->execute();
    }
}
