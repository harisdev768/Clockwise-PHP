<?php
namespace App\Modules\TimeClock\Services;

use App\Modules\TimeClock\Exceptions\ClockStatusException;
use App\Modules\TimeClock\Models\Hydrators\ClockStatusHydrator;
use App\Modules\TimeClock\Models\Mappers\ClockStatusMapper;
use App\Modules\TimeClock\Models\ClockStatus;

class ClockStatusService{

    private ClockStatusHydrator $hydrator;
    private ClockStatusMapper $mapper;

    public function __construct(ClockStatusHydrator $hydrator, ClockStatusMapper $mapper){
        $this->hydrator = $hydrator;
        $this->mapper = $mapper;
    }

    public function getClockStatus(ClockStatus $status): ClockStatus{
        $clockStatus = $this->mapper->fetchStatus($status);

        if(!$clockStatus->clockExists()){
            throw ClockStatusException::notFound();
        }
        
        return $clockStatus;
    }
}