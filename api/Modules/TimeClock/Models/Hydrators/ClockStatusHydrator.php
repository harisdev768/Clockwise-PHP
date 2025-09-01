<?php
namespace App\Modules\TimeClock\Models\Hydrators;

use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Models\ClockStatus;
use App\Modules\TimeClock\Models\Mappers\ClockStatusMapper;
use App\Modules\TimeClock\Models\Note;

class ClockStatusHydrator{

    public static function hydrateClock(array $data, ClockStatus $status): ClockStatus
    {
        $status->setUserId($data['user_id']);
        $status->setClockId($data['id']);
        $status->setClockInTime($data['clock_in']);
        $status->setClockOutTime($data['clock_out']);
        if(isset($data['clock_in']) && is_null($data['clock_out']) ){
            $status->setClocked(true);
        }
        return $status;
    }

    public static function hydrateActiveBreak(array $data, ClockStatus $status): ClockStatus
    {
        $status->setBreakId($data['id']);
        $status->setBreakStart($data['started_at']);
        $status->setBreakEnd($data['ended_at']);
        if(isset($data['started_at']) && is_null($data['ended_at']) ){
            $status->setBreak(true);
        }
        return $status;
    }

    public static function hydrateNote(array $data): Note{
        $note = new Note();
        $note->setNoteId($data['id']);
        $note->setUserId($data['user_id']);
        $note->setClockId($data['clock_id']);
        $note->setNote($data['note']);
        $note->setNotedAt($data['added_at']);
        return $note;
    }

    public static function hydrateBreak(array $data): BreakTime{
        $break = new BreakTime();
        $break->setBreakId($data['id']);
        $break->setUserId($data['user_id']);
        $break->setClockId($data['clock_id']);
        $break->setStartedAt($data['started_at']);
        $break->setEndedAt($data['ended_at']);
        return $break;
    }
}
