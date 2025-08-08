<?php

namespace App\Modules\TimeClock\Response;


use App\Modules\TimeClock\Models\ClockStatus;

class ClockStatusResponse
{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(ClockStatus $status): void
    {
        if ($status->getNotesCollection()) {
            $notes = $status->getNotesCollection()->toArray();
        }
        if ($status->getBreakCollection()) {
            $breaks = $status->getBreakCollection()->toArray();
        }
        self::json([
            'success' => true,
            'message' => "Clock status successfully created",
            'data' => [
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'clockStatus' => $status->getClocked(),
                'breakStatus' => $status->getBreak(),
                'meta' => [
                    'user_id' => $status->getUserId(),
                    'clock_id' => $status->getClockId(),
                    'clock_in_at' => $status->getClockInTime(),
                    'clock_out_at' => $status->getClockOutTime(),
                    'break_id' => $status->getBreakId(),
                    'break_started_at' => $status->getBreakStart(),
                    'break_ended_at' => $status->getBreakEnd(),
                ],
                'breaks' => $breaks ?? null,
                'notes' => $notes ?? null,
            ],

        ], 200);


    }
    public static function notFound(ClockStatus $status): void
    {
        if ($status->getNotesCollection()) {
            $notes = $status->getNotesCollection()->toArray();
        }
        if ($status->getBreakCollection()) {
            $breaks = $status->getBreakCollection()->toArray();
        }
        self::json([
            'success' => true,
            'message' => "Clock Doesn't exist",
            'data' => [
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
                'clockStatus' => $status->getClocked(),
                'breakStatus' => $status->getBreak(),
                'meta' => [
                    'user_id' => null,
                    'clock_id' => null,
                    'clock_in_at' => null,
                    'clock_out_at' => null,
                    'break_id' => null,
                    'break_started_at' => null,
                    'break_ended_at' => null,
                ],
                'breaks' => $breaks ?? null,
                'notes' => $notes ?? null,
            ],

        ], 200);


    }

    public static function error(string $message): void
    {
        self::json([
            'success' => false,
            'message' => $message
        ], 200);
    }
}