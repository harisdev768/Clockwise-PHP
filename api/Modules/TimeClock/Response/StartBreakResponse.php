<?php
namespace App\Modules\TimeClock\Response;


use App\Modules\TimeClock\Models\BreakTime;

class StartBreakResponse {

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(BreakTime $break): void
    {
        self::json([
            'success' => true,
            'message' => "Break Started Successfully",
            'data' => [
                'break_id' => $break->getBreakId(),
                'clock_id' => $break->getClockId(),
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'started_at' => $break->getStartedAt(),
                'ended_at' => $break->getEndedAt(),
            ],
        ], 200);


    }
    public static function error(string $message): void{
        self::json([
            'success' => false,
            'message' => $message
        ], 200);
    }
}