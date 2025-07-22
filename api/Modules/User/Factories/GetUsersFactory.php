<?php
namespace App\Modules\User\Factories;

use App\Config\Container;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\Mappers\UserMapper;
use App\Modules\User\Services\UserService;


class GetUsersFactory
{
    private Container $container;
    public function __construct(Container $container){
        $this->container = $container;
    }
    public function handle()
    {
        $service = $this->container->get(UserService::class); // ✅ use DI container
        return $service->getAllUsers(); // Will return JSON
    }
}
