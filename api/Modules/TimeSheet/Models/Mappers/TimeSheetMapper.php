<?php

namespace App\Modules\TimeSheet\Models\Mappers;

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

    public function fetchAll(): timeSheetCollection
    {
        $sql = "SELECT t.id, t.user_id, t.clock_in, t.clock_out, u.username , u.first_name, u.last_name, u.id 
                FROM clock_entries t
                JOIN users u ON u.id = t.user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $timeSheetCollection = new TimeSheetCollection();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $timesheet = new TimeSheet();
            $timesheet->setId($row['id']);
            $timesheet->setUserId($row['user_id']);
            $timesheet->setClockIn(new \DateTime($row['clock_in']));
            $timesheet->setClockOut($row['clock_out'] ? new \DateTime($row['clock_out']) : null);
            $timesheet->setUserName($row['username']); // from users table

            $timeSheetCollection->add($timesheet);
        }
        return $timeSheetCollection;
    }

}
