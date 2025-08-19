<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Requests\ClockRequest;
use App\Modules\TimeClock\UseCases\ClockInUseCase;

class ClockInController {

    private ClockInUseCase  $useCase;
    public function __construct(ClockInUseCase $useCase){
        $this->useCase = $useCase;
    }

    public function handleClockIn(ClockRequest $clockRequest) {
        $clock = new Clock();
        $clock->setUserId($clockRequest->getUserId());

        $this->useCase->execute($clock);

    }
}
