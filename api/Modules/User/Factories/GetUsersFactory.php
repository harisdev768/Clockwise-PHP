<?php
namespace App\Modules\User\Factories;

use App\Config\Container;
use App\Modules\User\Controllers\GetUserController;


class GetUsersFactory
{
    private Container $container;
    public function __construct(Container $container){
        $this->container = $container;
    }
    public function handle($data)
    {
        $controller = $this->container->get(GetUserController::class);
        $controller->handle($data);
    }
}
