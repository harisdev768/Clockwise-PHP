<?php
namespace App\Modules\TimeSheet\UseCases;

use App\Modules\TimeSheet\Response\GetTimeSheetResponse;
use App\Modules\TimeSheet\Services\TimeSheetService;
use App\Modules\TimeSheet\Models\Collections\TimeSheetCollection;

class GetTimeSheetUseCase
{
    private TimeSheetService $service;

    public function __construct(TimeSheetService $service)
    {
        $this->service = $service;
    }

    public function execute(): TimeSheetCollection
    {
        GetTimeSheetResponse::success($this->service->getAllTimeSheets()->toArray());
        return $this->service->getAllTimeSheets();
    }
}
