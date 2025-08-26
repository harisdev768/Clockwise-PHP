<?php

namespace App\Modules\TimeSheet\Request;

use App\Modules\TimeSheet\Exceptions\TimeSheetException;

class TimeSheetApprovalRequest
{
    private $data;
    private ?int $clockId = null;
    private bool $status = false;

    public function __construct($data)
    {
        $this->data = $data;
        $this->clockId = $data['id'] ?? null;
        $this->status = $data['status'];
    }

    public function all(): array
    {
        return $this->data;
    }

    public function getClockId(): ?int
    {
        return $this->clockId;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

}