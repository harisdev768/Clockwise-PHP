<?php

namespace App\Modules\TimeSheet\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\TimeSheet\Models\TimeSheet;

class TimeSheetCollection extends AbstractCollection
{

    public function mapItemToArray($item): array
    {
        return [
            'id' => $item->getId(),
            'user_id' => $item->getUserId(),
            'user_name' => $item->getUserName(),
            'full_name' => $item->getFullName(),
            'clock_in' => $item->getClockIn()->format('Y-m-d H:i:s'),
            'clock_out' => $item->getClockOut()?$item->getClockOut()->format('Y-m-d H:i:s') : null,
            'total_shift' => $item->getTotalShift(),
            'break_duration' => $item->getBreakDuration(),
        ];
    }
}
