<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Exceptions\ClockOutException;
use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Requests\ClockRequest;
use App\Modules\TimeClock\Response\ClockOutResponse;
use App\Modules\TimeClock\Services\ClockService;

class ClockOutUseCase {
    private ClockService $service;
    public function __construct(ClockService $service) {
        $this->service = $service;
    }

    public function execute(Clock $clock): ClockOutResponse {

        !$this->service->isClockedIn($clock);
        $clockCheck = $this->service->isClockedIn($clock);

        if (!$clockCheck->clockExists()) {
            throw ClockOutException::notClockedIn();
        }

        if( !is_null($clock->getClockOutTime()) ){
            throw ClockOutException::alreadyClockedOut();
        }

        $clockedOut = $this->service->clockOut($clock);
        return ClockOutResponse::success($clockedOut);
    }
}
