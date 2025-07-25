<?php
namespace App\Modules\User\Exceptions;

use Exception;

class UserException extends Exception
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

    public static function emailFormat(): self
    {
        return new self("Invalid email format.", 422);
    }
    public static function emailExists(): self
    {
        return new self("Email Already Exist.", 422);
    }
    public static function userExists(): self
    {
        return new self("Username Already Exist. ", 422);
    }
    public static function passwordFormat(): self
    {
        return new self("Password must be at least 6 characters.", 422);
    }
    public static function unauthorized(): self
    {
        return new self("Invalid Credentials", 401);
    }

    public static function userNotAdded(): self
    {
        return new self("Try Again Later! Something went wrong.", 422);
    }

    public static function notAllowed(): self{
        return new self("Not allowed.", 422);
    }

    public static function roleNotFound(): self{
        return new self("Role not found.", 422);
    }

    public static function notFound(): self{
        return new self("Users not found.", 422);
    }

    public static function userIdMissing(): self{
        return new self("User id is Required.", 422);
    }

    public static function editUserFailed(): self{
        return new self("Failed to edit user.", 422);
    }

}
