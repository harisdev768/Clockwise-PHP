<?php
namespace App\Modules\TimeClock\Models\Hydrators;

use App\Modules\TimeClock\Models\BreakTime;

class BreakHydrator {
    public static function hydrate(array $data): BreakTime {
        $break = new BreakTime();
        $break->setUserId($data['user_id']);
        $break->setBreakId($data['id']);
        $break->setClockId($data['clock_id']);
        $break->setStartedAt($data['started_at'] ?? null);
        $break->setEndedAt($data['ended_at'] ?? null);
        return $break;
    }
}
