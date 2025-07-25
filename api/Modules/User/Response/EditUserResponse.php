<?php
namespace App\Modules\User\Response;

class EditUserResponse{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success($data) {
        self::json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => [
                'id' => $data['user_id'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role' => $data['role'] ?? null ,
            ]
        ], 200);
    }

}