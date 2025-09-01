<?php
namespace App\Modules\TimeClock\Models;

use App\Modules\TimeClock\Models\Collections\BreakCollection;
use App\Modules\TimeClock\Models\Collections\NoteCollection;

class ClockStatus {
    private ?int $userId = null;
    private ?string $clockInTime = null;
    private ?string $clockOutTime = null;
    private ?string $breakStart = null;
    private ?string $breakEnd = null;
    private ?string $notes = null;
    private ?int $clockId = null;
    private ?int $breakId = null;
    private bool $clocked = false;
    private bool $isBreak = false;

    private BreakTime $breakTime;

    private ?BreakCollection $breakCollection = null;

    private ?NoteCollection $noteCollection = null;

    public function clockExists() : bool
    {
        if( isset($this->userId) ){
            return true;
        }
        return false;

    }

    public function setBreakCollection(?BreakCollection $breakCollection): void{
        $this->breakCollection = $breakCollection;
    }
    public function getBreakCollection(): ?BreakCollection{
        return $this->breakCollection;
    }

    public function setNotesCollection(?NoteCollection $collection): void{
        $this->noteCollection = $collection;
    }
    public function getNotesCollection(): ?NoteCollection{
        return $this->noteCollection;
    }

    public function setBreakStart(?string $start) : void{ $this->breakStart = $start; }
    public function getBreakStart() : ?string{   return $this->breakStart;  }

    public function setBreakEnd(?string $end) : void{ $this->breakEnd = $end; }
    public function getBreakEnd() : ?string{   return $this->breakEnd;  }

    public function setBreak(bool $isBreak) : void{ $this->isBreak = $isBreak; }
    public function getBreak() : bool{ return $this->isBreak; }

    public function setClocked(bool $clocked): void{ $this->clocked = $clocked; }
    public function getClocked() : bool{ return $this->clocked; }

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

    public function getBreakId(): ?int { return $this->breakId; }
    public function setBreakId(?int $breakId): void { $this->breakId = $breakId; }
}
