<?php
namespace App\Modules\User\Exceptions;

use Exception;

class MetaException extends Exception
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
    public static function notFound(): self{
        return new self("Meta Data not found.", 422);
    }

    public static function notAllowed(): self{
        return new self("Not allowed.", 422);
    }
    public static function userIdMissing(): self{
        return new self("User id is Required.", 422);
    }

}
