<?php

// ==============================
// FACTORIES
// ==============================
use App\Config\Container;
use App\Core\Exceptions\ApiException;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Middleware\AuthMiddleware;
use App\Modules\ForgotPassword\Exceptions\ForgotPasswordException;
use App\Modules\ForgotPassword\Exceptions\ResetPasswordException;
use App\Modules\ForgotPassword\Factories\ForgotPasswordFactory;
use App\Modules\ForgotPassword\Factories\ResetPasswordFactory;
use App\Modules\ForgotPassword\Request\ForgotPasswordRequest;
use App\Modules\Login\Exceptions\LoginException;
use App\Modules\Login\Exceptions\TokenException;
use App\Modules\Login\Factories\JWTFactory;
use App\Modules\Login\Factories\LoginFactory;
use App\Modules\Login\Models\Mappers\UserMapper;
use App\Modules\Login\Models\Mappers\UserTokenMapper;
use App\Modules\Login\Requests\CookieRequest;
use App\Modules\Login\Requests\LoginRequest;
use App\Modules\Login\Services\JWTService;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Factories\AddUserFactory;
use App\Modules\User\Factories\GetUsersFactory;


// ==============================
// CONTAINER
// ==============================


// ==============================
// RESPONSE CLASSES
// ==============================


// ==============================
// SERVICES
// ==============================


// ==============================
// MAPPERS
// ==============================


// ==============================
// REQUESTS
// ==============================


// ==============================
// EXCEPTIONS
// ==============================


// ==============================
// CONTAINER SETUP / BINDINGS
// ==============================

// Get or create singleton container instance
$container ??= Container::getInstance();

// Services
$container->bind(JWTService::class, fn() => new JWTService());

// Factories
$container->bind(LoginFactory::class, fn() => new LoginFactory($container));
$container->bind(ForgotPasswordFactory::class, fn() => new ForgotPasswordFactory($container));
$container->bind(ResetPasswordFactory::class, fn() => new ResetPasswordFactory($container));
$container->bind(JWTFactory::class, fn() => new JWTFactory($container));
$container->bind(AddUserFactory::class, fn() => new AddUserFactory($container));
$container->bind(GetUsersFactory::class, fn() => new GetUsersFactory($container) );

// Mappers
$container->bind(UserMapper::class, fn() => new UserMapper($container->get(PDO::class)));
$container->bind(UserTokenMapper::class, new UserTokenMapper($container->get(PDO::class)));

// Exceptions
$container->bind(ApiException::class, fn() => new ApiException());

// Requests
$container->bind(LoginRequest::class, fn() => new Request());
$container->bind(CookieRequest::class, fn() => new CookieRequest());
$container->bind(ForgotPasswordRequest::class, fn() => new ForgotPasswordRequest());

// Auth Middleware

$container->bind(AuthMiddleware::class, fn() => new AuthMiddleware());

// Middleware-style functions
function handleLogin()
{
    $request = Container::getInstance()->get(Request::class);
    $data = $request->all();

    if (empty($data)) {
        throw LoginException::unauthorized();
    }

    if (empty($data['email']) || empty($data['password'])) {
        throw LoginException::missingCredentials();
    }

    Container::getInstance()->get(LoginFactory::class)->handleRequest($data);
}

function handleLogout()
{
    setcookie('jwt', '', [
        'expires' => time() - 3600,  // Expire in the past
        'path' => '/',
        'domain' => 'localhost',     // EXACT same as when set
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    return Response::logout($_COOKIE);
}

function handleMe()
{

    $tokenString = Container::getInstance()->get(CookieRequest::class)->getCookie();

    if (!$tokenString) {
        throw TokenException::missingToken();
    }
    Container::getInstance()->get(JWTFactory::class)->handleJWT($tokenString);
}

function handleForgotPassword()
{
    $request = Container::getInstance()->get(Request::class);
    $data = $request->all();
    $email = $data['email'];

    if (empty($email)) {
        throw ForgotPasswordException::missingEmail();
    }

    Container::getInstance()->get(ForgotPasswordFactory::class)->handler($data);
}

function handleResetPassword()
{
    $request = Container::getInstance()->get(Request::class);
    $data = $request->all();
    $token = $data['token'];
    $newPassword = $data['new_password'];

    if ( empty($token) || empty($newPassword) ) {
        throw ResetPasswordException::missingCredentials();
    }

    Container::getInstance()->get(ResetPasswordFactory::class)->handler($data);
}

function handleAddUser()
{


    $middleware = Container::getInstance()->get(AuthMiddleware::class);

    if( $middleware->handle('add_user') ) {

        $container = Container::getInstance();
        $data = $container->get(Request::class)->all();

        if (
            empty($data['first_name']) ||
            empty($data['last_name']) ||
            empty($data['email']) ||
            empty($data['username']) ||
            empty($data['password'])
        ) {
            throw UserException::missingCredentials();
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw UserException::emailFormat();
        }

        if (strlen($data['password']) < 6) {
            throw UserException::passwordFormat();
        }

        // Call the factory
        $container->get(AddUserFactory::class)->handle($data);
    } else{
        throw UserException::notAllowed();
    }
}

function handleGetUsers()
{
    $middleware = Container::getInstance()->get(AuthMiddleware::class);

    if ($middleware->handle('get_users')) {

        $container = Container::getInstance();
        $response = $container->get(GetUsersFactory::class)->handle();
    } else {
        throw UserException::notAllowed();
    }

}

function handleEditUser(){
    $middleware = Container::getInstance()->get(AuthMiddleware::class);
    if ($middleware->handle('edit_user')) {
        $container = Container::getInstance();
        $data = $container->get(Request::class)->all();
        print_r($data);

    }else{
        throw UserException::notAllowed();
    }
}