<?php
namespace App\Modules\TimeClock\Requests;

use DateTime;

class ClockRequest {
    private int $userId;
    private string $action;

    public function __construct(array $data) {
        $this->userId = (int) $data['user_id'] ?? null;
        $this->action = $data['action'] ?? null;
    }

    public function getUserId(): int { return $this->userId; }
    public function getAction(): string { return $this->action; }
}
