<?php

namespace App\Modules\TimeSheet\UseCases;

use App\Modules\TimeSheet\Models\TimeSheetSearchFilter;
use App\Modules\TimeSheet\Request\GetTimeSheetRequest;
use App\Modules\TimeSheet\Response\GetTimeSheetResponse;
use App\Modules\TimeSheet\Services\TimeSheetService;
use App\Modules\TimeSheet\Models\Collections\TimeSheetCollection;
use DateTime;

class GetTimeSheetUseCase
{
    private TimeSheetService $service;

    public function __construct(TimeSheetService $service)
    {
        $this->service = $service;
    }

    public function execute(GetTimeSheetRequest $request): GetTimeSheetResponse
    {
        $filter = new TimeSheetSearchFilter();

        if ($request->getKeyword() !== null) {
            $filter->setKeyword($request->getKeyword());
        }
        if (!empty($request->getDepartmentId())) {
            $filter->setDepartmentId((int)$request->getDepartmentId());
        }
        if ($request->getJobRoleId() !== null) {
            $filter->setJobRoleId((int)$request->getJobRoleId());
        }
        if ($request->getLocationId() !== null) {
            $filter->setLocationId((int)$request->getLocationId());
        }
        if ($request->getStartDate() !== null) {
            $startDate = $request->getStartDate();
            $filter->setStartDate($startDate instanceof \DateTime ? $startDate : new \DateTime($startDate));
        }

        if ($request->getEndDate() !== null) {
            $endDate = $request->getEndDate();
            $filter->setEndDate($endDate instanceof \DateTime ? $endDate : new \DateTime($endDate));
        }


        $users = !$filter->isEmpty()
            ? $this->service->getAllTimeSheetsWithParams($filter)
            : $this->service->getAllTimeSheets();
        return GetTimeSheetResponse::success($users->toArray());
    }
}
