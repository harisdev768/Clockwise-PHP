<?php

namespace App\Modules\TimeSheet\Models\Mappers;

use App\Modules\TimeSheet\Models\Collections\BreakCollection;
use App\Modules\TimeSheet\Models\TimeSheetSearchFilter;
use App\Modules\TimeSheet\Models\TimeSheetStatus;
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
        t.id AS clock_entry_id,
        t.user_id,
        t.clock_in,
        t.clock_out,
        t.status,
        t.deleted,
        
        u.id AS uid,
        u.username,
        u.first_name,
        u.last_name,
        u.role_id,
        ur.role_name,
        u.job_role_id AS position_id,
        jr.name AS position_name,
        u.department_id,
        d.name AS department_name,
        u.location_id,
        l.name AS location_name,
        
        b.id AS break_id,
        b.started_at AS break_in,
        b.ended_at AS break_out
        
    FROM clock_entries t
    JOIN users u ON u.id = t.user_id
    LEFT JOIN break_entries b ON b.clock_id = t.id
    LEFT JOIN user_roles ur ON ur.role_id = u.role_id
    LEFT JOIN job_roles jr ON jr.id = u.job_role_id
    LEFT JOIN departments d ON d.id = u.department_id
    LEFT JOIN locations l ON l.id = u.location_id
    
    WHERE t.deleted = 0
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

    public function fetchAllWithParams(TimeSheetSearchFilter $filter): TimeSheetCollection
    {
        $sql = "
        SELECT 
            t.id AS clock_entry_id,
            t.user_id,
            t.clock_in,
            t.clock_out,
            t.status,
            t.deleted,
            
            u.id AS uid,
            u.username,
            u.first_name,
            u.last_name,
            u.role_id,
            ur.role_name,
            u.job_role_id AS position_id,
            jr.name AS position_name,
            u.department_id,
            d.name AS department_name,
            u.location_id,
            l.name AS location_name,
            
            b.id AS break_id,
            b.started_at AS break_in,
            b.ended_at AS break_out
            
        FROM clock_entries t
        JOIN users u ON u.id = t.user_id
        LEFT JOIN break_entries b ON b.clock_id = t.id
        LEFT JOIN user_roles ur ON ur.role_id = u.role_id
        LEFT JOIN job_roles jr ON jr.id = u.job_role_id
        LEFT JOIN departments d ON d.id = u.department_id
        LEFT JOIN locations l ON l.id = u.location_id
        
        WHERE t.deleted = 0
    ";

        $params = [];
        $types = [];

        // Keyword search across username, first_name, last_name
        $keyword = $filter->getKeyword();
        if (!empty($keyword)) {
            $keyword = trim($keyword);
            if ($keyword !== '') {
                $sql .= " AND (u.username LIKE :kw 
                        OR u.first_name LIKE :kw 
                        OR u.last_name LIKE :kw)";
                $params[':kw'] = '%' . $keyword . '%';
                $types[':kw'] = PDO::PARAM_STR;
            }
        }

        // Location filter
        $locationId = $filter->getLocationId();
        if (!empty($locationId)) {
            $sql .= " AND u.location_id = :location_id";
            $params[':location_id'] = (int)$locationId;
            $types[':location_id'] = PDO::PARAM_INT;
        }

        // Department filter
        $departmentId = $filter->getDepartmentId();
        if (!empty($departmentId)) {
            $sql .= " AND u.department_id = :department_id";
            $params[':department_id'] = (int)$departmentId;
            $types[':department_id'] = PDO::PARAM_INT;
        }

        // Job Role filter
        $jobRoleId = $filter->getJobRoleId();
        if (!empty($jobRoleId)) {
            $sql .= " AND u.job_role_id = :job_role_id";
            $params[':job_role_id'] = (int)$jobRoleId;
            $types[':job_role_id'] = PDO::PARAM_INT;
        }
        // Date range filter
        $startDate = $filter->getStartDate();
        $endDate = $filter->getEndDate();
        if ($startDate !== null && $endDate !== null) {
            $sql .= " AND t.clock_in BETWEEN :start_date AND :end_date";
            $params[':start_date'] = $startDate->format('Y-m-d 00:00:00');
            $params[':end_date'] = $endDate->format('Y-m-d 23:59:59');
            $types[':start_date'] = PDO::PARAM_STR;
            $types[':end_date'] = PDO::PARAM_STR;
        }

        $sql .= " ORDER BY t.clock_in DESC";


        $stmt = $this->db->prepare($sql);
        foreach ($params as $name => $value) {
            $stmt->bindValue($name, $value, $types[$name] ?? PDO::PARAM_STR);
        }
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

    public function updateClockStatus(TimeSheetStatus $status): TimeSheetStatus
    {
        $sql = "UPDATE clock_entries SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':status', $status->getStatus(), PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $status->getClockId(), PDO::PARAM_INT);

        $updatedStatus = $stmt->execute();

        if ($updatedStatus) {
            return $status;
        } else {
            return new TimeSheetStatus();
        }
    }
}
