<?php
namespace App\Modules\TimeClock\Controllers;

use App\Modules\TimeClock\Models\ClockStatus;
use App\Modules\TimeClock\UseCases\GetStatusUseCase;
use App\Modules\TimeClock\Requests\StatusRequest;

class ClockStatusController{

    private GetStatusUseCase $useCase;

    public function __construct(GetStatusUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(StatusRequest $request): void
    {
        $status = new ClockStatus();
        $status->setUserId($request->getUserId());
        $this->useCase->execute($status);
    }

}


