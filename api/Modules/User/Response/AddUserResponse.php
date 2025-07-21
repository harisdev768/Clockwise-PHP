<?php
namespace App\Modules\User\Response;

class AddUserResponse{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }



    public static function success() {
        self::json([
            'success' => true,
            'message' => "User was successfully added!",
        ], 200);
    }

    public static function error(string $message): void{
        self::json([
            'success' => false,
            'message' => $message
        ], 200);

    }

}