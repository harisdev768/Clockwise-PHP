<?php
namespace App\Modules\Login\UseCases;


use App\Modules\Login\Models\User;
use App\Modules\Login\Requests\LoginRequest;
use App\Modules\Login\Response\LoginResponse;
use App\Modules\Login\Services\JWTService;
use App\Modules\Login\Services\LoginUserService;
use App\Modules\Login\Models\Mappers\UserTokenMapper;

use App\Modules\Login\Exceptions\LoginException;

class LoginUseCase {
    private LoginUserService $userService;
    private JWTService $jwtService;
    private UserTokenMapper $tokenMapper;
    public function __construct(LoginUserService $userService, JWTService $jwtService , UserTokenMapper $tokenMapper) {
        $this->userService = $userService;
        $this->jwtService = $jwtService;
        $this->tokenMapper = $tokenMapper;
    }
    public static function setCookie($token)
    {
        if(isset($token)){
            setcookie(
                'jwt',
                $token,
                [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'domain' => 'localhost',
                    'secure' => false,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );
        }
    }
    public function execute(LoginRequest $request): LoginResponse {

        $user = new User();
        $user->setIdentifier($request->getEmail());
        $user->setPassword($request->getPassword());
        $user = $this->userService->login($user);

        if ($user->userExists()) {
            $payload = [
                'name' => $user->getFirstName().' '.$user->getLastName(),
                'user_id' => $user->getUserId()->getUserIdVal(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()->getRoleName(),
                'status' => $user->getStatus(),
            ];

            $token = $this->jwtService->generateToken($payload);
            $this->tokenMapper->saveToken($user->getUserID()->getUserIdVal(), $token);
            self::setCookie($token);

            return LoginResponse::success($payload,"Login successful!" , $token );

        } else {

            throw LoginException::unauthorized();

        }

    }
}