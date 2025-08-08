<?php
namespace App\Modules\TimeClock\Factories;

use App\Config\Container;
use App\Modules\TimeClock\Controllers\EndBreakController;
use App\Modules\TimeClock\Requests\BreakRequest;

class EndBreakFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    public function handleEndBreak(array $data){
        $controller = $this->container->get(EndBreakController::class);
        $controller->handleEndBreak(new BreakRequest($data));
    }
}