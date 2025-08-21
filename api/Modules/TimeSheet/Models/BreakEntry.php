<?php
namespace App\Modules\TimeSheet\Models;

use DateTime;

class BreakEntry
{
    private int $id;
    private int $clockEntryId;
    private ?DateTime $breakIn;
    private ?DateTime $breakOut;

    public function setId(int $id): void { $this->id = $id; }
    public function setClockEntryId(int $clockEntryId): void { $this->clockEntryId = $clockEntryId; }
    public function setBreakIn(?DateTime $breakIn): void { $this->breakIn = $breakIn; }
    public function setBreakOut(?DateTime $breakOut): void { $this->breakOut = $breakOut; }

    public function getId(): int { return $this->id; }
    public function getClockEntryId(): int { return $this->clockEntryId; }
    public function getBreakIn(): ?DateTime { return $this->breakIn; }
    public function getBreakOut(): ?DateTime { return $this->breakOut; }

    public function getDuration(): int
    {
        if (!$this->breakIn || !$this->breakOut) {
            return 0;
        }
        $in = new \DateTime($this->breakIn);
        $out = new \DateTime($this->breakOut);
        return $out->getTimestamp() - $in->getTimestamp();
    }
}
