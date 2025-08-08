<?php
namespace App\Modules\TimeClock\Exceptions;

use Exception;

class ClockStatusException extends Exception
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

    public static function notFound(): self
    {
        return new self("Clock Not Found.", 404);
    }
    public static function userIdMissing(): self{
        return new self("User Id Missing.", 400);
    }


}
