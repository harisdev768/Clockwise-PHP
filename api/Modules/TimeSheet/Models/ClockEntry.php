<?php
namespace App\Modules\TimeSheet\Models;

class ClockEntry
{
    private int $id;
    private int $userId;
    private \DateTime $clockIn;
    private ?\DateTime $clockOut = null;

    public function getId(): int { return $this->id; }
    public function setId(int $id): void { $this->id = $id; }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }

    public function getClockIn(): \DateTime { return $this->clockIn; }
    public function setClockIn(\DateTime $clockIn): void { $this->clockIn = $clockIn; }

    public function getClockOut(): ?\DateTime { return $this->clockOut; }
    public function setClockOut(?\DateTime $clockOut): void { $this->clockOut = $clockOut; }
}
