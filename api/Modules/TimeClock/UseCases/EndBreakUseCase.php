<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Exceptions\EndBreakException;
use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Response\EndBreakResponse;
use App\Modules\TimeClock\Services\BreakService;

class EndBreakUseCase {
    private BreakService $service;
    public function __construct(BreakService $service) {
        $this->service = $service;
    }

    public function execute(BreakTime $break): EndBreakResponse {

        $breakCheck = $this->service->isBreakStarted($break);

        if (!$breakCheck->breakExists()) {
            throw EndBreakException::breakNotStarted();
        }

        if( !is_null($break->getEndedAt()) ){
            throw EndBreakException::alreadyEndedBreak();
        }

        $breakEnded = $this->service->EndBreak($break);
        return EndBreakResponse::success($breakEnded);
    }
}
