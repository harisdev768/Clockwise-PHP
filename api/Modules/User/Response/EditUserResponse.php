<?php
namespace App\Modules\User\Response;

use App\Modules\User\Models\User;

class EditUserResponse{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    public static function success(User $user) {
        self::json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => [
                'id' => $user->getUserId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()->getRoleName() ?? null,
            ]
        ], 200);
    }

    public static function successUser(User $data) {
        self::json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => [
                'id' => $data->getUserId(),
                'first_name' => $data->getFirstName(),
                'last_name' => $data->getLastName(),
                'email' => $data->getEmail(),
                'role' => $data->getRole()->getRoleId() ?? null ,
                'role_id' => $data->getRole()->getRoleName() ?? null ,
            ]
        ], 200);
    }


}