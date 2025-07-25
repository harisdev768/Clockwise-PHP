<?php

namespace App\Modules\User\Request;

use App\Exceptions\UserException;

class EditUserRequest
{
    public function validate(array $data)
    {
        if (empty($data['first_name']) || empty($data['last_name']) || empty($data['email'])) {
            throw UserException::invalidRequest("All fields are required.");
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw UserException::emailFormat();
        }
    }
}

