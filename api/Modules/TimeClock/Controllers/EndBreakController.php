<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Requests\BreakRequest;
use App\Modules\TimeClock\UseCases\EndBreakUseCase;

class EndBreakController {

    private EndBreakUseCase  $useCase;
    public function __construct(EndBreakUseCase $useCase){
        $this->useCase = $useCase;
    }

    public function handleEndBreak(BreakRequest $Request) {
        $break = new BreakTime();
        $break->setUserId($Request->getUserId());
        $break->setClockId($Request->getClockId());
        $this->useCase->execute($break);

    }
}
