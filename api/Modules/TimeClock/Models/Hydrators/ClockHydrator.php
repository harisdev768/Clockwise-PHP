<?php
namespace App\Modules\TimeClock\Models\Hydrators;

use App\Modules\TimeClock\Models\Clock;

class ClockHydrator {
    public static function hydrate(array $data): Clock {
        $clock = new Clock();
        $clock->setUserId($data['user_id']);
        $clock->setClockId($data['id']);
        $clock->setClockInTime($data['clock_in'] ?? null);
        $clock->setClockOutTime($data['clock_out'] ?? null);
        $clock->setNotes($data['notes'] ?? null);
        return $clock;
    }
}
