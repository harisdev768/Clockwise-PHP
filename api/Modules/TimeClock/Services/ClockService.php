<?php
namespace App\Modules\TimeClock\Services;

use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Models\Mappers\ClockMapper;
use App\Modules\TimeClock\Response\ClockInResponse;

class ClockService {
    private ClockMapper $mapper;

    public function __construct(ClockMapper $mapper) {
        $this->mapper = $mapper;
    }

    public function clockIn(Clock $clock): Clock {
        $clock->setClockInTime((new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        $this->mapper->insertClockIn($clock);
        return $clock;
    }

    public function clockOut(Clock $clock): Clock {
        $clock->setClockOutTime((new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        return $this->mapper->updateClockOut($clock);;
    }

    public function isClockedIn(Clock $clock): Clock {
        return $this->mapper->getLastUnclosedEntry( $clock );
    }
}
