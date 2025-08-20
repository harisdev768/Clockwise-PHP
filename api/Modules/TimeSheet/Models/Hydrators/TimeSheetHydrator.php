<?php
namespace App\Modules\TimeSheet\Models\Hydrators;

use App\Modules\TimeSheet\Models\TimeSheet;

class TimeSheetHydrator
{
    public static function hydrate(array $row): TimeSheet
    {
        $timeSheet = new TimeSheet();
        $timeSheet->setId((int) $row['id']);
        $timeSheet->setUserId((int) $row['user_id']);
        $timeSheet->setUserName($row['user_name']);
        $timeSheet->setClockIn(new \DateTime($row['clock_in']));
        $timeSheet->setClockOut($row['clock_out'] ? new \DateTime($row['clock_out']) : null);

        // calculate shift & break duration (dummy calc for now)
        if ($row['clock_out']) {
            $interval = (new \DateTime($row['clock_in']))->diff(new \DateTime($row['clock_out']));
            $timeSheet->setTotalShift($interval->format('%H:%I:%S'));
        } else {
            $timeSheet->setTotalShift(null);
        }

        // break calculation – we’ll refine later
        $timeSheet->setBreakDuration("00:00:00");

        return $timeSheet;
    }
}
