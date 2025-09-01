<?php
namespace App\Modules\TimeClock\Models;

class Clock {
    private ?int $userId = null;
    private ?string $clockInTime = null;
    private ?string $clockOutTime = null;
    private ?string $notes = null;
    private ?int $clockId = null;

    public function clockExists() : bool
    {
        if( isset($this->userId) ){
            return true;
        }
        return false;

    }

    public function getUserId(): ?int { return $this->userId; }
    public function setUserId(?int $id): void { $this->userId = $id; }

    public function getClockId(): ?int{ return $this->clockId; }
    public function setClockId(?int $id): void { $this->clockId = $id; }

    public function getClockInTime(): ?string { return $this->clockInTime; }
    public function setClockInTime(?string $time): void { $this->clockInTime = $time; }

    public function getClockOutTime(): ?string { return $this->clockOutTime; }
    public function setClockOutTime(?string $time): void { $this->clockOutTime = $time; }

    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(?string $notes): void { $this->notes = $notes; }
}
