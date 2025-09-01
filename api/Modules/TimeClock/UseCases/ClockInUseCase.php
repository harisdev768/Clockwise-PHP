<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Services\ClockService;
use App\Modules\TimeClock\Response\ClockInResponse;
use App\Modules\TimeClock\Exceptions\ClockInException;

class ClockInUseCase {
    private ClockService $service;
    public function __construct(ClockService $service) {
        $this->service = $service;
    }

    public function execute(Clock $clock): ClockInResponse {

        $clockedIn = $this->service->isClockedIn($clock);

        if($clockedIn->clockExists()){
            throw ClockInException::alreadyClockedIn();
        }

        $clockedIn = $this->service->clockIn($clock);
        return ClockInResponse::success($clockedIn);
    }
}
