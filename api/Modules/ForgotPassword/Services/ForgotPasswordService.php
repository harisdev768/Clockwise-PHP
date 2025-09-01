<?php

namespace App\Modules\ForgotPassword\Services;

use App\Modules\ForgotPassword\Exceptions\ForgotPasswordException;
use App\Modules\ForgotPassword\Response\ForgotPasswordResponse;
use App\Modules\Login\Models\Mappers\UserMapper;
use App\Modules\ForgotPassword\Mappers\PasswordResetMapper;
use App\Modules\ForgotPassword\Utilities\Mailer;
use App\Modules\Login\Models\User;
use DateTime;

class ForgotPasswordService {
    private UserMapper $userMapper;
    private PasswordResetMapper $resetMapper;
    private Mailer $mailer;

    public function __construct(UserMapper $userMapper, PasswordResetMapper $resetMapper, Mailer $mailer) {
        $this->userMapper = $userMapper;
        $this->resetMapper = $resetMapper;
        $this->mailer = $mailer;
    }

    public function sendResetEmail(User $userObject) {

        $email = $userObject->getEmail();

        $user = $this->userMapper->findByEmail($userObject);

        if (!$user->userExists()) {
            throw ForgotPasswordException::invalidEmail();
        }

        $token = bin2hex(random_bytes(32));
        $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
        $this->resetMapper->storeToken($email, $token, $expiresAt);

        $this->mailer->sendResetLink($email, $token);

        return ForgotPasswordResponse::success("Reset link has been emailed.");
    }
}