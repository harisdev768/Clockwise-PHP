<?php
namespace App\Modules\TimeClock\Models\Mappers;

use App\Config\DB;
use App\Modules\TimeClock\Models\BreakTime;
use App\Modules\TimeClock\Models\Hydrators\BreakHydrator;

class BreakMapper {
    private \PDO $pdo;

    public function __construct() {
        $this->pdo = DB::getConnection();
    }

    public function insertStartBreak(BreakTime $break): BreakTime {
        $stmt = $this->pdo->prepare("
            INSERT INTO break_entries (user_id, clock_id, started_at)
            VALUES (:user_id, :clock_id, :started_at)
        ");

        $stmt->bindValue(':user_id', $break->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $break->getClockId(), \PDO::PARAM_INT);
        $stmt->bindValue(':started_at', $break->getStartedAt(), \PDO::PARAM_STR);

        $stmt->execute();

        $break->setBreakId($this->pdo->lastInsertId());
        return $break;
    }

    public function updateEndBreak(BreakTime $break): BreakTime {
        $stmt = $this->pdo->prepare("
            UPDATE break_entries
            SET ended_at = :ended_at
            WHERE user_id = :user_id
              AND clock_id = :clock_id
              AND ended_at IS NULL
            ORDER BY started_at DESC
            LIMIT 1
        ");

        $stmt->bindValue(':ended_at', $break->getEndedAt(), \PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $break->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $break->getClockId(), \PDO::PARAM_INT);

        $stmt->execute();

        return self::getBreakById($break);
    }

    public function getLastUnclosedEntry(BreakTime $break): ?BreakTime {
        $stmt = $this->pdo->prepare("
            SELECT * FROM break_entries 
            WHERE user_id = :user_id
              AND clock_id = :clock_id
              AND ended_at IS NULL 
            ORDER BY started_at DESC 
            LIMIT 1
        ");

        $stmt->bindValue(':user_id', $break->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $break->getClockId(), \PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? BreakHydrator::hydrate($data) : new BreakTime();
    }

    public function getBreakById(BreakTime $break): ?BreakTime {
        $stmt = $this->pdo->prepare("
            SELECT * FROM break_entries 
            WHERE user_id = :user_id 
              AND clock_id = :clock_id 
            ORDER BY started_at DESC 
            LIMIT 1
        ");

        $stmt->bindValue(':user_id', $break->getUserId(), \PDO::PARAM_INT);
        $stmt->bindValue(':clock_id', $break->getClockId(), \PDO::PARAM_INT);

        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $data ? BreakHydrator::hydrate($data) : $break;
    }
}
