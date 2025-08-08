<?php

namespace App\Modules\TimeClock\Models\Mappers;

use App\Modules\TimeClock\Models\ClockStatus;
use App\Modules\TimeClock\Models\Collections\BreakCollection;
use App\Modules\TimeClock\Models\Collections\NoteCollection;
use App\Modules\TimeClock\Models\Hydrators\ClockStatusHydrator;
use App\Config\DB;
use PDO;

class ClockStatusMapper
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }

    public function fetchActiveClock(ClockStatus $status): ClockStatus
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM clock_entries 
        WHERE user_id = :user_id 
          AND clock_out IS NULL 
        ORDER BY clock_in DESC 
        LIMIT 1
    ");
        $stmt->bindValue(':user_id', $status->getUserId(), \PDO::PARAM_INT);
        $stmt->execute();

        $clock = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$clock) {
            return new ClockStatus(); // no clock found
        }

        return ClockStatusHydrator::hydrateClock($clock, $status);
    }

    public function fetchActiveBreak(ClockStatus $status): ClockStatus
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM break_entries 
        WHERE user_id = :user_id 
          AND clock_id = :clock_id 
          AND ended_at IS NULL 
        ORDER BY started_at DESC 
        LIMIT 1
    ");
        $stmt->bindValue(':user_id', $status->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $status->getClockId(), \PDO::PARAM_INT);
        $stmt->execute();

        $break = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($break) {
            $status = ClockStatusHydrator::hydrateActiveBreak($break, $status);
        }

        return $status;
    }

    public function fetchEndedBreaks(ClockStatus $status): ClockStatus
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM break_entries 
        WHERE user_id = :user_id 
          AND clock_id = :clock_id
          AND ended_at IS NOT NULL
        ORDER BY started_at ASC
    ");
        $stmt->bindValue(':user_id', $status->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $status->getClockId(), \PDO::PARAM_INT);
        $stmt->execute();

        $breaksFetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $breaks = [];

        foreach ($breaksFetched as $break) {
            $breaks[] = ClockStatusHydrator::hydrateBreak($break);
        }

        $status->setBreakCollection(new BreakCollection($breaks));

        return $status;
    }

    public function fetchNotes(ClockStatus $status): ClockStatus
    {
        $stmt = $this->pdo->prepare("
        SELECT * FROM note_entries 
        WHERE user_id = :user_id 
          AND clock_id = :clock_id  
        ORDER BY added_at ASC
    ");
        $stmt->bindValue(':user_id', $status->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $status->getClockId(), \PDO::PARAM_INT);
        $stmt->execute();

        $notesFetched = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $notes = [];

        foreach ($notesFetched as $note) {
            $notes[] = ClockStatusHydrator::hydrateNote($note);
        }

        $status->setNotesCollection(new NoteCollection($notes));

        return $status;
    }

}
