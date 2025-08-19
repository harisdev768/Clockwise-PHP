<?php
namespace App\Modules\TimeClock\Models;

class BreakTime {
    private int $userId;
    private int $clockId;
    private ?string $startedAt = null;
    private ?string $endedAt = null;
    private ?int $breakId = null;

    public function breakExists() : bool
    {
        if( isset($this->userId) && isset($this->clockId) ) {
            return true;
        }
        return false;

    }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $id): void { $this->userId = $id; }

    public function getClockId(): ?int { return $this->clockId; }
    public function setClockId(?int $id): void { $this->clockId = $id; }

    public function getBreakId(): int{ return $this->breakId; }
    public function setBreakId(int $id): void { $this->breakId = $id; }
    public function getStartedAt() : ?string { return $this->startedAt; }
    public function setStartedAt(?string $startedAt): void { $this->startedAt = $startedAt; }

    public function getEndedAt() : ?string { return $this->endedAt; }
    public function setEndedAt(?string $endedAt): void { $this->endedAt = $endedAt; }
}
