<?php

namespace App\Modules\TimeSheet\Models\Hydrators;

use App\Modules\TimeSheet\Models\BreakEntry;
use App\Modules\TimeSheet\Models\Collections\BreakCollection;
use App\Modules\TimeSheet\Models\TimeSheet;

use DateTime;


class TimeSheetHydrator
{
    public static function hydrate(array $row, int $breaksDuration): TimeSheet
    {
        $timeSheet = new TimeSheet();
        $timeSheet->setId((int)$row['clock_entry_id']);
        $timeSheet->setUserId((int)$row['user_id']);
        $timeSheet->setUserName($row['username']);
        $timeSheet->setFullName($row['first_name'] . " " . $row['last_name']);
        $timeSheet->setClockIn(new \DateTime($row['clock_in']));
        $timeSheet->setClockOut($row['clock_out'] ? new \DateTime($row['clock_out']) : null);

        $shiftSeconds = 0;
        if ($timeSheet->getClockOut()) {
            $shiftSeconds = $timeSheet->getClockOut()->getTimestamp() - $timeSheet->getClockIn()->getTimestamp();
        }

        $timeSheet->setBreakDuration(self::formatSeconds($breaksDuration));
        $timeSheet->setTotalShift($shiftSeconds > 0 ? self::formatSeconds($shiftSeconds) : null);

        return $timeSheet;
    }

    private static function formatSeconds(int $seconds): string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }


    public static function hydrateBreak(array $row): BreakEntry
    {
        $break = new BreakEntry();
        $break->setId((int)$row['id']);
        $break->setClockEntryId((int)$row['clock_id']);
        $break->setBreakIn(new \DateTime($row['started_at']));
        $break->setBreakOut($row['ended_at'] ? new \DateTime($row['ended_at']) : null);
        return $break;
    }
}
