<?php

namespace App\Core\Middleware;

use App\Config\Container;
use App\Modules\Login\Exceptions\TokenException;
use App\Modules\Login\Requests\CookieRequest;
use App\Modules\Login\Services\JWTService;
use App\Modules\Login\Factories\JWTFactory;
use App\Modules\User\Exceptions\UserException;

class AuthMiddleware
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = require __DIR__ . './../../Modules/User/Config/UserConfig.php';

    }

    public function handle(string $requiredPermission)
    {
        $container = Container::getInstance();
        $jwtService = $container->get(JWTService::class);
        $token = Container::getInstance()->get(CookieRequest::class)->getCookie();

        if (!$token) {
            throw TokenException::missingToken();
        }

        $tokenString = Container::getInstance()->get(CookieRequest::class)->getCookie();

        if (!$tokenString) {
            throw TokenException::missingToken();
        }


        $decoded = $jwtService->validateToken($token);

        if ( !isset($decoded['role']) ) {
            throw TokenException::invalidToken();
        }

        $role = $decoded['role'];

        if (!isset($this->permissions['roles'][$role])) {
            throw UserException::roleNotFound(); // Role not found
        }

        if (!in_array($requiredPermission, $this->permissions['roles'][$role]['permissions'])) {
            throw UserException::notAllowed(); // Permission denied
        }

        // Auth + permission OK → proceed
        return true;
    }
}
