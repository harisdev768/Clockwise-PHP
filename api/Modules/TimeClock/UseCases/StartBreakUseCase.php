<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Exceptions\StartBreakException;
use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Services\BreakService;
use App\Modules\TimeClock\Response\StartBreakResponse;

class StartBreakUseCase {
    private BreakService $service;
    public function __construct(BreakService $service) {
        $this->service = $service;
    }

    public function execute(BreakTime $break): StartBreakResponse {

        $breakStarted = $this->service->isBreakStarted($break);

        if($breakStarted->breakExists()){
            throw StartBreakException::breakAlreadyStarted();
        }

        $breakStarted = $this->service->startBreak($break);
        return StartBreakResponse::success($breakStarted);
    }
}
