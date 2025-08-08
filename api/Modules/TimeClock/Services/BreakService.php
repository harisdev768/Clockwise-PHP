<?php
namespace App\Modules\TimeClock\Services;

use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Models\Mappers\BreakMapper;
use App\Modules\TimeClock\Response\StartBreakResponse;

class BreakService {
    private BreakMapper $mapper;

    public function __construct(BreakMapper $mapper) {
        $this->mapper = $mapper;
    }

    public function startBreak(BreakTime $break): BreakTime {
        $break->setStartedAt((new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        return $this->mapper->insertStartBreak($break);
    }

    public function EndBreak(BreakTime $break): BreakTime {
        $break->setEndedAt((new \DateTimeImmutable())->format('Y-m-d H:i:s'));
        return $this->mapper->updateEndBreak($break);
    }

    public function isBreakStarted(BreakTime $break): BreakTime {
        return $this->mapper->getLastUnclosedEntry( $break );
    }
}
