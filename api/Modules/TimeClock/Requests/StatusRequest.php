<?php
namespace App\Modules\TimeClock\Requests;

use DateTime;

class StatusRequest {

    private int $userId;

    public function __construct(array $data) {
        $this->userId = (int) $data['user_id'] ?? null;
    }

    public function getUserId(): int { return $this->userId; }
}
