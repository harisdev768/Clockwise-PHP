<?php

namespace App\Modules\TimeSheet\Models\Hydrators;

use App\Modules\TimeSheet\Models\TimeSheet;

class TimeSheetHydrator
{
    public static function hydrate(array $row): TimeSheet
    {
        $timeSheet = new TimeSheet();
        $timeSheet->setId((int)$row['clock_entry_id']); // clock entry id
        $timeSheet->setUserId((int)$row['user_id']);    // user id
        $timeSheet->setUserName($row['username']);
        $timeSheet->setFullName($row['first_name'] . ' ' . $row['last_name']);
        $timeSheet->setClockIn(new \DateTime($row['clock_in']));
        $timeSheet->setClockOut($row['clock_out'] ? new \DateTime($row['clock_out']) : null);

        // calculate shift duration
        if ($row['clock_out']) {
            $interval = (new \DateTime($row['clock_in']))->diff(new \DateTime($row['clock_out']));
            $timeSheet->setTotalShift($interval->format('%H:%I:%S'));
        } else {
            $timeSheet->setTotalShift(null);
        }

        // break calculation (placeholder)
        $timeSheet->setBreakDuration("00:00:00");

        return $timeSheet;
    }

}
