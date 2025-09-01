<?php

namespace App\Modules\TimeSheet\Response;

use App\Modules\TimeSheet\Models\TimeSheetStatus;

class TimeSheetApprovalResponse
{

    public static function json($data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function success(TimeSheetStatus $status)
    {
        self::json([
            'success' => true,
            'message' => 'TimeSheet Status Updated',
            'data' => [
                'clockId' => $status->getClockId(),
                'status' => $status->getStatus() ? 'Approved' : 'Unapproved',
            ]
        ], 200);
    }



}