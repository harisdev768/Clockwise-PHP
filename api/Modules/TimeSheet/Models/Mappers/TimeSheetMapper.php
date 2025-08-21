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
        $sql = "SELECT 
        t . id as clock_entry_id, 
        t . user_id, 
        t . clock_in, 
        t . clock_out, 
        u . id as user_id, 
        u . username, 
        u . first_name, 
        u . last_name
    FROM clock_entries t
    JOIN users u ON u . id = t . user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $timeSheetCollection = new TimeSheetCollection();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


            $timeSheetCollection->add(TimeSheetHydrator::hydrate($row));
        }
        return $timeSheetCollection;
    }

}
