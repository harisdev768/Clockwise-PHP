<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Requests\ClockRequest;;
use App\Modules\TimeClock\UseCases\ClockOutUseCase;

class ClockOutController {

    private ClockOutUseCase $useCase;
    public function __construct(ClockOutUseCase $useCase){
        $this->useCase = $useCase;
    }

    public function handleClockOut(ClockRequest $clockRequest) {
        $clock = new Clock();
        $clock->setUserId($clockRequest->getUserId());

        $this->useCase->execute($clock);

    }
}
