<?php
namespace App\Modules\TimeClock\Models\Hydrators;

use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Models\Note;

class NoteHydrator {
    public static function hydrate(array $data): Clock {
        $note = new Note();
        $note->setUserId($data['user_id']);
        $note->set($data['id']);
        $clock->setClockInTime($data['clock_in'] ?? null);
        $clock->setClockOutTime($data['clock_out'] ?? null);
        $clock->setNotes($data['notes'] ?? null);
        return $clock;
    }
}
