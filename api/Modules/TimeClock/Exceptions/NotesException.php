<?php
namespace App\Modules\TimeClock\Exceptions;

use Exception;

class NotesException extends Exception
{
    protected $message;
    protected int $statusCode;

    public function __construct(string $message = "Bad Request", int $statusCode = 400)
    {
        parent::__construct($message);
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
            'code' => $this->getCode(),
        ];
    }

    public static function userIdMissing(): self{
        return new self("User Id Missing.", 400);
    }

    public static function notesEmpty(): self{
        return new self("Notes are empty.", 400);
    }

    public static function notClockedIn(): self{
        return new self("User Clocked out.", 403);
    }


}
