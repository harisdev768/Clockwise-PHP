<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Requests\BreakRequest;
use App\Modules\TimeClock\UseCases\StartBreakUseCase;

class StartBreakController {

    private StartBreakUseCase  $useCase;
    public function __construct(StartBreakUseCase $useCase){
        $this->useCase = $useCase;
    }

    public function handleStartBreak(BreakRequest $Request) {
        $break = new BreakTime();
        $break->setUserId($Request->getUserId());
        $break->setClockId($Request->getClockId());
        $this->useCase->execute($break);

    }
}
