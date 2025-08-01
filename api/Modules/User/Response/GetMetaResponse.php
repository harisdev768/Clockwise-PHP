<?php
namespace App\Modules\User\Response;

class GetMetaResponse{


    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(array $departments , array $jobroles , array $locations) {
        self::json([
            'success' => true,
            'data' => [
                'departments' => $departments,
                'jobroles' => $jobroles,
                'locations' => $locations
            ]
        ], 200);
    }


}