<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\ClockInController;
use App\Modules\TimeClock\Requests\ClockRequest;

class ClockInFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handleClockIn(array $data){
        $controller = $this->container->get(ClockInController::class);
        $controller->handleClockIn(new ClockRequest($data));
    }
}