<?php
namespace App\Modules\TimeSheet\Response;

class GetTimeSheetResponse{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(array $data) {
        self::json([
            'success' => true,
            'data' => $data
        ], 200);
    }


}