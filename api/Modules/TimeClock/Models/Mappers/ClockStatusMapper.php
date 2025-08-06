<?php

namespace App\Modules\TimeClock\Models\Mappers;

use App\Modules\TimeClock\Models\ClockStatus;
use App\Modules\TimeClock\Models\Hydrators\ClockStatusHydrator;
use App\Config\DB;
use PDO;

class ClockStatusMapper{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }


    public function fetchStatus(ClockStatus $status): ClockStatus
    {
        // get active clock for user
        $stmt = $this->pdo->prepare(
            "SELECT * FROM clock_entries WHERE user_id = :user_id AND clock_out IS NULL ORDER BY clock_in DESC LIMIT 1"
        );
        $stmt->execute(['user_id' => $status->getUserId()]);
        $clock = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$clock) {
            return new ClockStatus();
        }

        $statusHydrated = ClockStatusHydrator::hydrateClock($clock , $status);

        // if active clock found, check for active break
        $stmt = $this->pdo->prepare(
            "SELECT * FROM break_entries WHERE user_id = :user_id AND clock_id = :clock_id AND ended_at IS NULL ORDER BY started_at DESC LIMIT 1"
        );
        $stmt->execute([
            'user_id'  => $statusHydrated->getUserId(),
            'clock_id' => $statusHydrated->getClocked(),
        ]);
        $break = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($break) {
            return ClockStatusHydrator::hydrateBreak($break , $statusHydrated);
        }

        return $statusHydrated;
    }
}