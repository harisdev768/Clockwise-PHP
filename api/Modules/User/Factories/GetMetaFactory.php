<?php

namespace App\Modules\User\Factories;

use App\Config\Container;
use App\Modules\User\Controllers\GetMetaController;

class GetMetaFactory{
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }
    public function handle(){
        $controller = $this->container->get(GetMetaController::class);
        $controller->handle();
    }
}
