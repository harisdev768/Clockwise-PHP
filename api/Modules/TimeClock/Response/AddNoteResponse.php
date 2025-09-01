<?php
namespace App\Modules\TimeClock\Response;

use App\Modules\TimeClock\Models\Note;

class AddNoteResponse {

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(Note $note): void
    {
        self::json([
            'success' => true,
            'message' => "Clocked-In Successfully",
            'data' => [
                'note' => $note->getNote(),
                'note_id' => $note->getNoteId(),
                'noted_at' => $note->getNotedAt(),
                'clock_id' => $note->getClockId(),
                'user_id' => $note->getUserId(),
                'time' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
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