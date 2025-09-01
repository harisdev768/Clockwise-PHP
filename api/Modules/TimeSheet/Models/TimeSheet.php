<?php
namespace App\Modules\TimeSheet\Models;

use DateTime;

class TimeSheet
{
    private int $id;
    private int $userId;
    private string $userName;
    private string $fullName;
    private DateTime $clockIn;
    private ?DateTime $clockOut;
    private ?string $totalShift;
    private ?string $breakDuration;
    private string $role ;
    private string $position;
    private string $location;
    private string $department;
    private bool $status = false;
    private bool $deleted = false;

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setFullName(string $fullName): void{
        $this->fullName = $fullName;
    }

    public function getFullName(): string{
        return $this->fullName;
    }

    public function setClockIn(DateTime $clockIn): void
    {
        $this->clockIn = $clockIn;
    }

    public function getClockIn(): DateTime
    {
        return $this->clockIn;
    }

    public function setClockOut(?DateTime $clockOut): void
    {
        $this->clockOut = $clockOut;
    }

    public function getClockOut(): ?DateTime
    {
        return $this->clockOut;
    }

    public function setTotalShift(?string $totalShift): void
    {
        $this->totalShift = $totalShift;
    }

    public function getTotalShift(): ?string
    {
        return $this->totalShift;
    }

    public function setBreakDuration(?string $breakDuration): void
    {
        $this->breakDuration = $breakDuration;
    }

    public function getBreakDuration(): ?string
    {
        return $this->breakDuration;
    }
}
