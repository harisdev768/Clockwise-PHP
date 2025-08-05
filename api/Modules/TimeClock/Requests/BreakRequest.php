<?php
namespace App\Modules\TimeClock\Requests;

use DateTime;

class BreakRequest {
    private int $userId;
    private int $clockId;
    private string $action;

    public function __construct(array $data) {
        $this->userId = (int) $data['user_id'] ?? null;
        $this->clockId = (int) $data['clock_id'] ?? null;
        $this->action = $data['action'] ?? null;
    }

    public function getUserId(): int { return $this->userId; }
    public function getClockId(): int { return $this->clockId; }
    public function getAction(): string { return $this->action; }
}
