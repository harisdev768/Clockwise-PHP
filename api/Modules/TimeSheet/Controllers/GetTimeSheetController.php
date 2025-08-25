<?php

namespace App\Modules\TimeSheet\Controllers;

use App\Modules\TimeSheet\Request\GetTimeSheetRequest;
use App\Modules\TimeSheet\UseCases\GetTimeSheetUseCase;

class GetTimeSheetController
{
    private GetTimeSheetUseCase $useCase;

    public function __construct(GetTimeSheetUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle($data): void
    {
        $this->useCase->execute(new GetTimeSheetRequest($data));
    }
}
