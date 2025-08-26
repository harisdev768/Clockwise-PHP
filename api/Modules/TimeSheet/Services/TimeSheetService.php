<?php
namespace App\Modules\TimeSheet\Services;

use App\Modules\TimeSheet\Models\Mappers\TimeSheetMapper;
use App\Modules\TimeSheet\Models\Collections\TimeSheetCollection;
use App\Modules\TimeSheet\Models\TimeSheet;
use App\Modules\TimeSheet\Models\TimeSheetStatus;

class TimeSheetService
{
    private TimeSheetMapper $mapper;

    public function __construct(TimeSheetMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getAllTimeSheets(): TimeSheetCollection
    {
        return $this->mapper->fetchAll();
    }

    public function getAllTimeSheetsWithParams($filter)
    {
        return $this->mapper->fetchAllWithParams($filter);
    }

    public function updateTimesheetStatus(TimeSheetStatus $status): TimeSheetStatus
    {
        return $this->mapper->updateClockStatus($status);
    }
}
