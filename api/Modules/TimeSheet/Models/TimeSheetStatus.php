<?php

namespace App\Modules\TimeSheet\Models;

class TimeSheetStatus
{
    private ?int $clockId = null;
    private bool $status = false;

    public function getClockId(): ?int
    {
        return $this->clockId;
    }

    public function setClockId(?int $clockId): void
    {
        $this->clockId = $clockId;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

}