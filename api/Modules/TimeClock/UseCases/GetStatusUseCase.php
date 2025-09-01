<?php
namespace App\Modules\TimeClock\UseCases;

use App\Modules\TimeClock\Exceptions\ClockStatusException;
use App\Modules\TimeClock\Response\ClockStatusResponse;
use App\Modules\TimeClock\Services\ClockStatusService;
use App\Modules\TimeClock\Models\ClockStatus;

class GetStatusUseCase{

    private ClockStatusService $service;

    public function __construct(ClockStatusService $service){
        $this->service = $service;
    }

    public function execute(ClockStatus $status){

        $clockStatus = $this->service->getClockStatus($status);
        if($clockStatus->clockExists()){
            return ClockStatusResponse::success($clockStatus);
        }
        return ClockStatusResponse::notFound($clockStatus);
    }


}