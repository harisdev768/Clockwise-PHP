<?php
namespace App\Modules\User\Factories;

use App\Config\Container;
use App\Modules\User\Controllers\EditUserController;

class EditUserFactory
{
    private Container $container;

    public function __construct(Container $container) {
        $this->container = Container::getInstance();
    }

    public function handle($data)
    {
        $controller = $this->container->get(EditUserController::class);
        $controller->handle($data);
    }
}
