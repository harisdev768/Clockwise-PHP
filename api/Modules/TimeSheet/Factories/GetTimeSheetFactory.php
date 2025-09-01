<?php
namespace App\Modules\TimeSheet\Factories;

use App\Config\Container;
use App\Modules\TimeSheet\Controllers\GetTimeSheetController;

class GetTimeSheetFactory{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function handle($data)
    {
        $controller = $this->container->get(GetTimeSheetController::class);
        $controller->handle($data);
    }

}
