<?php

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
use App\Modules\TimeSheet\Exceptions\TimeSheetException;
use App\Modules\TimeClock\Requests\ClockRequest;
use App\Modules\User\Exceptions\UserException;
use App\Modules\User\Factories\AddUserFactory;
use App\Modules\User\Factories\GetMetaFactory;
use App\Modules\User\Factories\GetUsersFactory;
use App\Modules\User\Factories\EditUserFactory;
use App\Modules\TimeClock\Factories\ClockInFactory;
use App\Modules\TimeClock\Factories\ClockOutFactory;
use App\Modules\TimeClock\Factories\StartBreakFactory;
use App\Modules\TimeClock\Factories\EndBreakFactory;
use App\Modules\TimeClock\Exceptions\ClockInException;
use App\Modules\TimeClock\Factories\ClockStatusFactory;
use App\Modules\TimeClock\Exceptions\ClockStatusException;
use \App\Modules\TimeClock\Exceptions\NotesException;
use App\Modules\TimeClock\Factories\AddNoteFactory;
use App\Modules\User\Exceptions\MetaException;
use App\Modules\TimeSheet\Factories\GetTimeSheetFactory;
use App\Modules\TimeSheet\Factories\TimeSheetApprovalFactory;

$container ??= Container::getInstance();

// Services
$container->bind(JWTService::class, fn() => new JWTService());

// Factories
$container->bind(LoginFactory::class, fn() => new LoginFactory($container));
$container->bind(ForgotPasswordFactory::class, fn() => new ForgotPasswordFactory($container));
$container->bind(ResetPasswordFactory::class, fn() => new ResetPasswordFactory($container));
$container->bind(JWTFactory::class, fn() => new JWTFactory($container));
$container->bind(AddUserFactory::class, fn() => new AddUserFactory($container));
$container->bind(GetUsersFactory::class, fn() => new GetUsersFactory($container));
$container->bind(EditUserFactory::class, fn() => new EditUserFactory($container));
$container->bind(ClockInFactory::class, fn() => new ClockInFactory($container));
$container->bind(ClockOutFactory::class, fn() => new ClockOutFactory($container));
$container->bind(StartBreakFactory::class, fn() => new StartBreakFactory($container));
$container->bind(EndBreakFactory::class, fn() => new EndBreakFactory($container));
$container->bind(ClockStatusFactory::class, fn() => new ClockStatusFactory($container));
$container->bind(AddNoteFactory::class, fn() => new AddNoteFactory($container));
$container->bind(GetMetaFactory::class, fn() => new GetMetaFactory($container));
$container->bind(GetTimeSheetFactory::class, fn() => new GetTimeSheetFactory($container));
$container->bind(TimeSheetApprovalFactory::class, fn() => new TimeSheetApprovalFactory($container));

// Mappers
$container->bind(UserMapper::class, fn() => new UserMapper($container->get(PDO::class)));
$container->bind(UserTokenMapper::class, new UserTokenMapper($container->get(PDO::class)));

// Exceptions
$container->bind(ApiException::class, fn() => new ApiException());
$container->bind(UserException::class, fn() => new UserException());
$container->bind(LoginException::class, fn() => new LoginException());
$container->bind(MetaException::class, fn() => new MetaException());

// Requests
$container->bind(LoginRequest::class, fn() => new Request());
$container->bind(CookieRequest::class, fn() => new CookieRequest());
$container->bind(ForgotPasswordRequest::class, fn() => new ForgotPasswordRequest());

// Auth Middleware

$container->bind(AuthMiddleware::class, fn() => new AuthMiddleware());

function handleLogin()
{
    $request = Container::getInstance()->get(Request::class);
    $data = $request->all();
    try {
        if (empty($data)) {
            throw LoginException::unauthorized();
        }

        if (empty($data['email']) || empty($data['password'])) {
            throw LoginException::missingCredentials();
        }

        Container::getInstance()->get(LoginFactory::class)->handleRequest($data);
    } catch (\Throwable $e) {
        http_response_code($e->getStatusCode() ?: 500);

        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }

}

function handleAddUser()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('add_user')) {

            $container = Container::getInstance();
            $data = $container->get(Request::class)->all();

            if (
                empty(trim($data['first_name'])) ||
                empty(trim($data['last_name'])) ||
                empty(trim($data['email'])) ||
                empty($data['username']) ||
                empty($data['password']) ||
                empty(trim($data['role_id']))
            ) {
                throw UserException::missingCredentials();
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw UserException::emailFormat();
            }

            if (strlen($data['password']) < 6) {
                throw UserException::passwordFormat();
            }

            $container->get(AddUserFactory::class)->handle($data);
        } else {
            throw UserException::notAllowed();
        }
    } catch (\Exception $e) {
        http_response_code($e->getStatusCode() ?: 500);
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }
}

function handleLogout()
{
    setcookie('jwt', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'domain' => 'localhost',
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

    if (empty($token) || empty($newPassword)) {
        throw ResetPasswordException::missingCredentials();
    }

    Container::getInstance()->get(ResetPasswordFactory::class)->handler($data);
}


function handleGetUsers()
{
    $middleware = Container::getInstance()->get(AuthMiddleware::class);

    if ($middleware->handle('get_users')) {
        $container = Container::getInstance();
        $request = Container::getInstance()->get(Request::class);
        $data = $request->all();
        $container->get(GetUsersFactory::class)->handle($data);
    } else {
        throw UserException::notAllowed();
    }

}

function handleGetMeta(){

    $middleware = Container::getInstance()->get(AuthMiddleware::class);

    if ($middleware->handle('get_meta')) {
        $container = Container::getInstance();
        $container->get(GetMetaFactory::class)->handle();
    }else{

        throw MetaException::notAllowed();

    }
}

function handleEditUser($userId)
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('edit_user')) {
            $request = Container::getInstance()->get(Request::class);
            $id = $userId ?? null;

            if (!$id) {
                throw UserException::userIdMissing();
            }

            $data = $request->addUserId($id);

            if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
                throw UserException::missingCredentials();
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw UserException::emailFormat();
            }

            $factory = Container::getInstance()->get(EditUserFactory::class);
            $factory->handle($data);
        }

        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code((int)($e->getStatusCode() ?: 500));
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }

}

function handleClock()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('clock_update')) {
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();

            if (empty($data['user_id'])) {
                throw ClockInException::userIdMissing();
            }
            if (empty($data['action'])) {
                throw ClockInException::userActionMissing();
            }

            if ($data['action'] === 'in') {
                $factory = Container::getInstance()->get(ClockInFactory::class);
                $factory->handleClockIn($data);
            } else if ($data['action'] === 'out') {
                $factory = Container::getInstance()->get(ClockOutFactory::class);
                $factory->handleClockOut($data);
            }
        }
        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code($e->getStatusCode() ?: 500);
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }

}

function handleBreak()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('break_update')) {
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();

            if (empty($data['user_id'])) {
                throw ClockInException::userIdMissing();
            }
            if (empty($data['action'])) {
                throw ClockInException::userActionMissing();
            }

            if ($data['action'] === 'start') {
                $factory = Container::getInstance()->get(StartBreakFactory::class);
                $factory->handleStartBreak($data);
            } else if ($data['action'] === 'end') {
                $factory = Container::getInstance()->get(EndBreakFactory::class);
                $factory->handleEndBreak($data);
            }
        }
        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code($e->getStatusCode() ?: 500);
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }
}

function handleClockStatus()
{

    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('clock_status')) {
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();

            if (empty($data['user_id'])) {
                throw ClockStatusException::userIdMissing();
            }

            $container = Container::getInstance();
            $response = $container->get(ClockStatusFactory::class)->handle($data);
        }
        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code($e->getStatusCode() ?: 500);
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }

}

function handleAddNote()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('add_note')) {
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();

            if (empty($data['clock_id'])) {
                throw NotesException::notClockedIn();
            }
            if (empty($data['user_id'])) {
                throw NotesException::userIdMissing();
            }
            if (empty($data['note'])) {
                throw NotesException::notesEmpty();
            }
            if (strlen($data['note']) > 512) {
                throw NotesException::notesTooLong();
            }
            $container = Container::getInstance();
            $container->get(AddNoteFactory::class)->handleAddNotes($data);
        }
        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code($e->getStatusCode() ?: 500);
        header('Content-Type: application/json');
        Response::error($e->getMessage());
    }
}

function handleGetTimesheet()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('get_timesheet')) {
            $container = Container::getInstance();
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();
            $container->get(GetTimeSheetFactory::class)->handle($data);
        }

        throw UserException::notAllowed();

    } catch (\Exception $e) {
        http_response_code((int)($e->getCode() ?: 500));
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
}

function handleTimesheetApproval()
{
    try {
        $middleware = Container::getInstance()->get(AuthMiddleware::class);

        if ($middleware->handle('get_timesheet')) {
            $container = Container::getInstance();
            $request = Container::getInstance()->get(Request::class);
            $data = $request->all();
            $id = $data['id'] ?? null;
            $status = $data['status'] ?? null;
            if (!$id) {
                throw TimeSheetException::clockIdMissing();
            }
            if ($status === null) {
                throw TimeSheetException::timeSheetStatusMissing();
            }

            $container->get(TimeSheetApprovalFactory::class)->handle($data);
        }
        throw UserException::notAllowed();
    } catch (\Exception $e) {
        http_response_code((int)($e->getCode() ?: 500));
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }

}