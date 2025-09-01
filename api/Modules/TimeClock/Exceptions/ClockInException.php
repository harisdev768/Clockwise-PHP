<?php
namespace App\Modules\TimeClock\Exceptions;

use Exception;

class ClockInException extends Exception
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

    public static function alreadyClockedIn(): self
    {
        return new self("User Already Clocked-In.", 400);
    }

    public static function userIdMissing(): self{
        return new self("User Id Missing.", 400);
    }

    public static function userActionMissing(): self{
        return new self("User Action Missing.", 400);
    }
}
