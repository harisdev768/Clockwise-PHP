<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\StartBreakController;
use App\Modules\TimeClock\Requests\BreakRequest;

class StartBreakFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handleStartBreak(array $data){
        $controller = $this->container->get(StartBreakController::class);
        $controller->handleStartBreak(new BreakRequest($data));
    }
}