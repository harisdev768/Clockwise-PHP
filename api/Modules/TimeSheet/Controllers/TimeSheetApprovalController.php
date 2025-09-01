<?php

namespace App\Modules\TimeSheet\Controllers;

use App\Modules\TimeSheet\Request\TimeSheetApprovalRequest;
use App\Modules\TimeSheet\UseCases\TimeSheetApprovalUseCase;

class TimeSheetApprovalController
{
    private TimeSheetApprovalUseCase $useCase;

    public function __construct(TimeSheetApprovalUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle($data): void
    {
        $this->useCase->execute(new TimeSheetApprovalRequest($data));
    }
}
