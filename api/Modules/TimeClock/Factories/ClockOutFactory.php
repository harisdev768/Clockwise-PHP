<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\ClockOutController;
use App\Modules\TimeClock\Requests\ClockRequest;

class ClockOutFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handleClockOut(array $data){
        $controller = $this->container->get(ClockOutController::class);
        $controller->handleClockOut(new ClockRequest($data));
    }
}