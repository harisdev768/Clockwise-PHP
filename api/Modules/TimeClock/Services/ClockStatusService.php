<?php

namespace App\Modules\TimeClock\Services;

use App\Modules\TimeClock\Exceptions\ClockStatusException;
use App\Modules\TimeClock\Models\Hydrators\ClockStatusHydrator;
use App\Modules\TimeClock\Models\Mappers\ClockStatusMapper;
use App\Modules\TimeClock\Models\ClockStatus;

class ClockStatusService
{

    private ClockStatusHydrator $hydrator;
    private ClockStatusMapper $mapper;

    public function __construct(ClockStatusHydrator $hydrator, ClockStatusMapper $mapper)
    {
        $this->hydrator = $hydrator;
        $this->mapper = $mapper;
    }

    public function getClockStatus(ClockStatus $status): ClockStatus
    {
        $status = $this->mapper->fetchActiveClock($status);

        if (!$status->clockExists()) {
            return $status;
        }

        $this->mapper->fetchActiveBreak($status);
        $this->mapper->fetchEndedBreaks($status);
        $this->mapper->fetchNotes($status);
        return $status;
    }

}