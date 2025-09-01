<?php
namespace App\Modules\ForgotPassword\Exceptions;

use Exception;
use http\Client\Curl\User;

class ResetPasswordException extends Exception
{
    protected int $statusCode;

    public function __construct(string $message = "Bad Request", int $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        http_response_code($this->statusCode);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'code' => $this->getStatusCode(),
        ];
    }


    public static function missingCredentials(): self
    {
        return new self("Token and new password are required", 422);
    }
    public static function tokenExpired(): self{
        return new self("Token is invalid or expired. Please try again.", 400);
    }
}
