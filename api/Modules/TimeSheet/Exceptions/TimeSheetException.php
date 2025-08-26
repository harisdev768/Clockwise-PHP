<?php
namespace App\Modules\TimeSheet\Exceptions;

use Exception;

class TimeSheetException extends Exception
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
            'code' => $this->getCode(),
        ];
    }

    // Methods for specific login errors

    public static function missingCredentials(): self
    {
        return new self("All fields are required.", 422);
    }

    public static function clockIdMissing(): self{
        return new self("Clock ID is Required.", 422);
    }

    public static function editClockFailed(): self{
        return new self("Failed to edit TimeSheet.", 422);
    }

    public static function timeSheetStatusMissing(): self{
        return new self("Time Sheet Status Missing.", 422);
    }

}
