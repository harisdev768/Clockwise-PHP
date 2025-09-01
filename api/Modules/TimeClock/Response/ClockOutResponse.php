<?php
namespace App\Modules\TimeClock\Response;


use App\Modules\TimeClock\Models\Clock;

class ClockOutResponse {

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(Clock $clock): void
    {
        self::json([
            'success' => true,
            'message' => "Clocked-Out Successfully",
            'data' => [
                'clock_id' => $clock->getClockId(),
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'clockedInTime' => $clock->getClockInTime(),
                'clockedOutTime' => $clock->getClockOutTime(),
            ],
        ], 200);


    }
    public static function error(string $message): void{
        self::json([
            'success' => false,
            'message' => $message
        ], 400);
    }
}