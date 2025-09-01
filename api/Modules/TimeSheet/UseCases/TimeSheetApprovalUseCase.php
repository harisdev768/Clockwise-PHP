<?php

namespace App\Modules\TimeSheet\UseCases;

use App\Modules\TimeSheet\Models\TimeSheetStatus;
use App\Modules\TimeSheet\Request\TimeSheetApprovalRequest;
use App\Modules\TimeSheet\Response\TimeSheetApprovalResponse;
use App\Modules\TimeSheet\Services\TimeSheetService;

class TimeSheetApprovalUseCase
{
    private TimeSheetService $service;

    public function __construct(TimeSheetService $service)
    {
        $this->service = $service;
    }

    public function execute(TimeSheetApprovalRequest $request): TimeSheetApprovalResponse
    {
        $status = new TimeSheetStatus();
        $status->setClockId($request->getClockId());
        $status->setStatus($request->getStatus());

        return TimeSheetApprovalResponse::success($this->service->updateTimesheetStatus($status));
    }
}
