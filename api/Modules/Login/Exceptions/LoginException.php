<?php
namespace App\Modules\Login\Exceptions;

use Exception;

class LoginException extends Exception
{
    protected $message;
    protected int $statusCode;

    public function __construct(string $message = "Bad Request", int $statusCode = 400)
    {
        parent::__construct($message,$statusCode);
        $this->statusCode = $statusCode;
        $this->message = $message;
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
        return new self("Email and password are required", 422);
    }

    public static function unauthorized(): self
    {
        return new self("Invalid email or password", 401);
    }

    public static function deactivated(): self
    {
        return new self("Your account has been deactivated", 403);
    }


}
