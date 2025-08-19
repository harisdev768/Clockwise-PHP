<?php
namespace App\Modules\TimeClock\Models\Collections;

use App\Core\Collections\AbstractCollection;
use App\Modules\TimeClock\Models\BreakTime;

class BreakCollection extends AbstractCollection
{
    public function mapItemToArray($item): array
    {
        return [
            'break_id' => $item->getBreakId(),
            'break_started_at' => $item->getStartedAt(),
            'break_ended_at' => $item->getEndedAt() ?? null,
        ];
    }

}
