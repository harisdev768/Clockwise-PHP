<?php
namespace App\Modules\TimeClock\Models\Collections;

use App\Modules\TimeClock\Models\BreakTime;

class BreakCollection{

    private array $breaks = [];

    public function __construct(array $breaks = [])
    {
        foreach ($breaks as $break) {
            $this->add($break);
        }
    }

    public function add(BreakTime $break): void
    {
        $this->breaks[] = $break;
    }

    public function toArray(): array
    {
        return array_map(function (BreakTime $break) {
            return [
                'break_id' => $break->getBreakId(),
                'break_started_at' => $break->getStartedAt(),
                'break_ended_at' => $break->getEndedAt() ?? null,
            ];
        }, $this->breaks);
    }

    public function all(): array
    {
        return $this->breaks;
    }
}
