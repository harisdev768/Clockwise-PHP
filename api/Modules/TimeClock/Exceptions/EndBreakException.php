<?php
namespace App\Modules\TimeClock\Exceptions;

use Exception;

class EndBreakException extends Exception
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

    public static function notClockedIn(): self
    {
        return new self("User is not Clocked-In", 400);
    }
    public static function alreadyClockedOut(): self
    {
        return new self("User Already Clocked-Out.", 400);
    }
    public static function breakNotStarted(): self
    {
        return new self("Break not started.", 400);
    }
    public static function alreadyEndedBreak(): self
    {
        return new self("Break already ended.", 400);
    }



}
