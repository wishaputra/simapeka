<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function logAction($action, $model, $recordId, $userNip, $oldData = null, $newData = null)
    {
        $logEntry = [
            'action' => $action,
            'model' => $model,
            'record_id' => $recordId,
            'user_nip' => $userNip,
            'timestamp' => now()->toDateTimeString(),
            'old_data' => $oldData,
            'new_data' => $newData,
        ];

        Log::info("CRUD Log Entry", $logEntry);
    }
}
