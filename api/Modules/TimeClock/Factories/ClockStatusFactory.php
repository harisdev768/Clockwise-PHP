<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\ClockStatusController;
use App\Modules\TimeClock\Requests\ClockRequest;
use App\Modules\TimeClock\Requests\StatusRequest;

class ClockStatusFactory{

    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handle(array $data)
    {
        $controller = $this->container->get(ClockStatusController::class);
        $controller->handle(new StatusRequest($data));
    }

}
