<?php
namespace App\Modules\TimeSheet\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\TimeSheet\Models\BreakEntry;

class BreakCollection extends AbstractCollection
{

    protected function mapItemToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'clock_entry_id' => $item->getClockEntryId(),
            'break_in' => $item->getBreakIn(),
            'break_out' => $item->getBreakOut(),
            'duration' => $item->getDuration(),
        ];
    }

    public function getTotalDuration(): int
    {
        return array_sum(array_map(fn($break) => $break->getDuration(), $this->items));
    }
}
