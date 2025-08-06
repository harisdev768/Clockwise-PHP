<?php
namespace App\Modules\TimeClock\Response;


use App\Modules\TimeClock\Models\ClockStatus;

class ClockStatusResponse {

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(ClockStatus $status): void
    {
        self::json([
            'success' => true,
            'message' => "Clock status successfully created",
            'data' => [
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'user_id' => $status->getUserId(),
                'clockStatus' => $status->getClocked(),
                'clock_id' => $status->getClockId(),
                'clock_in_at' => $status->getClockInTime(),
                'clock_out_at' => $status->getClockOutTime(),
                'breakStatus' => $status->getBreak(),
                'break_id' => $status->getBreakId(),
                'break_started_at' => $status->getBreakStart(),
                'break_ended_at' => $status->getBreakEnd(),
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