<?php
namespace App\Modules\TimeClock\Requests;

use DateTime;

class AddNoteRequest {
    private int $userId;
    private int $clockId;
    private string $note;

    public function __construct(array $data) {
        $this->userId = (int) $data['user_id'] ?? null;
        $this->clockId = (int) $data['clock_id'] ?? null;
        $this->note = $data['note'] ?? null;
    }

    public function getUserId(): int { return $this->userId; }
    public function getClockId(): int { return $this->clockId; }
    public function getNote(): string { return $this->note; }
}
