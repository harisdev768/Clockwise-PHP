<?php
namespace App\Modules\User\Factories;

use App\Modules\User\Controllers\EditUserController;

class EditUserFactory
{
    public function __invoke(array $vars)
    {
        $controller = container()->get(EditUserController::class);
        return $controller->handle($vars);
    }
}
