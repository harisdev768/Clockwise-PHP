<?php
namespace App\Modules\TimeClock\Models;

use DateTimeImmutable;

class Note {
    private int $userId;
    private int $clockId;
    private ?int $noteId = null;
    private ?string $note = null;

    private ?string $noted_at = null;

    private bool $isClockedIn = false;

    public function noteExists() : bool
    {
        if( isset($this->userId) && isset($this->clockId) && !is_null($this->note) ) {
            return true;
        }
        return false;

    }

    public function getUserId(): int { return $this->userId; }
    public function setUserId(int $id): void { $this->userId = $id; }

    public function getClockId(): ?int { return $this->clockId; }
    public function setClockId(?int $id): void { $this->clockId = $id; }

    public function getNoteId(): ?int { return $this->noteId; }
    public function setNoteId(?int $id): void { $this->noteId = $id; }

    public function getNote(): ?string { return $this->note; }
    public function setNote(?string $note): void { $this->note = $note; }

    public function isClockedIn(): bool { return $this->isClockedIn; }
    public function setClockedIn(bool $clockedIn): void { $this->isClockedIn = $clockedIn; }

    public function setNotedAt(?string $timestamp): void{ $this->noted_at = (string) $timestamp;  }
    public function getNotedAt(): ?string{ return $this->noted_at;   }
}
