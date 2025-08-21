<?php

namespace App\Modules\TimeSheet\Models\Mappers;

use App\Modules\TimeSheet\Models\Collections\BreakCollection;
use PDO;
use App\Modules\TimeSheet\Models\Collections\TimeSheetCollection;
use App\Modules\TimeSheet\Models\Hydrators\TimeSheetHydrator;
use App\Modules\TimeSheet\Models\TimeSheet;

class TimeSheetMapper
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function fetchAll(): TimeSheetCollection
    {
        $sql = "
        SELECT 
            t.id as clock_entry_id,
            t.user_id,
            t.clock_in,
            t.clock_out,
            u.id as user_id,
            u.username,
            u.first_name,
            u.last_name,
            u.role_id,
            u.job_role_id as position_id,
            u.location_id,
            b.id as break_id,
            b.started_at as break_in,
            b.ended_at as break_out
        FROM clock_entries t
        JOIN users u ON u.id = t.user_id
        LEFT JOIN break_entries b ON b.clock_id = t.id
        ORDER BY t.id, b.id
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $timeSheetCollection = new TimeSheetCollection();
        $currentEntryId = null;
        $breaksDuration = 0;
        $entryData = null;

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($currentEntryId !== null && $currentEntryId !== $row['clock_entry_id']) {
                $timeSheetCollection->add(TimeSheetHydrator::hydrate($entryData, $breaksDuration));
                $breaksDuration = 0; // reset for next entry
            }

            $currentEntryId = $row['clock_entry_id'];
            $entryData = $row;

            if (!empty($row['break_in']) && !empty($row['break_out'])) {
                $breakIn = new \DateTime($row['break_in']);
                $breakOut = new \DateTime($row['break_out']);
                $breaksDuration += $breakOut->getTimestamp() - $breakIn->getTimestamp();
            }
        }

        if ($entryData !== null) {
            $timeSheetCollection->add(TimeSheetHydrator::hydrate($entryData, $breaksDuration));
        }

        return $timeSheetCollection;
    }


}
