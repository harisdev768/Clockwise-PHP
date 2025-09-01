<?php

namespace App\Modules\TimeClock\Requests;

class BreakRequest
{
    private ?int $userId;
    private ?int $clockId;
    private ?string $action;

    public function __construct(array $data)
    {
        $this->userId = isset($data['user_id']) ? (int)$data['user_id'] : null;
        $this->clockId = isset($data['clock_id']) ? (int)$data['clock_id'] : null;
        $this->action = $data['action'] ?? null;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getClockId(): ?int
    {
        return $this->clockId;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }
}
