<?php
namespace App\Modules\TimeClock\Requests;

class ClockRequest {
    private int $userId;
    private string $action;

    public function __construct(array $data) {
        $this->userId = isset($data['user_id']) ? (int) $data['user_id'] : null;
        $this->action = $data['action'] ?? null;
    }

    public function getUserId(): int { return $this->userId; }
    public function getAction(): string { return $this->action; }
}
