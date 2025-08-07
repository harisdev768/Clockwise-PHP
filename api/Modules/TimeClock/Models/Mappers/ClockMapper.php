<?php
namespace App\Modules\TimeClock\Models\Mappers;

use App\Config\DB;
use App\Modules\TimeClock\Models\Clock;
use App\Modules\TimeClock\Models\Hydrators\ClockHydrator;

class ClockMapper {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DB::getConnection();
    }

    public function insertClockIn(Clock $clock): Clock {
        $stmt = $this->pdo->prepare("
            INSERT INTO clock_entries (user_id, clock_in)
            VALUES (:user_id, :clock_in)
        ");

        $stmt->bindValue(':user_id', $clock->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_in', $clock->getClockInTime(), \PDO::PARAM_STR);

        $stmt->execute();

        $clock->setClockId($this->pdo->lastInsertId());
        return $clock;
    }

    public function updateClockOut(Clock $clock): Clock {
        $stmt = $this->pdo->prepare("
            UPDATE clock_entries
            SET clock_out = :clock_out
            WHERE user_id = :user_id
              AND clock_out IS NULL
            ORDER BY clock_in DESC
            LIMIT 1
        ");

        $stmt->bindValue(':clock_out', $clock->getClockOutTime(), \PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $clock->getUserId(), \PDO::PARAM_INT);

        $stmt->execute();

        return self::getClockById($clock);
    }

    public function getLastUnclosedEntry(Clock $clock): ?Clock {
        $stmt = $this->pdo->prepare("
            SELECT * FROM clock_entries
            WHERE user_id = :user_id
              AND clock_out IS NULL
            ORDER BY clock_in DESC
            LIMIT 1
        ");

        $stmt->bindValue(':user_id', $clock->getUserId(), \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? ClockHydrator::hydrate($data) : new Clock();
    }

    public function getClockById(Clock $clock): ?Clock {
        $stmt = $this->pdo->prepare("
            SELECT * FROM clock_entries
            WHERE user_id = :user_id
            ORDER BY clock_in DESC
            LIMIT 1
        ");

        $stmt->bindValue(':user_id', $clock->getUserId(), \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? ClockHydrator::hydrate($data) : $clock;
    }
}
