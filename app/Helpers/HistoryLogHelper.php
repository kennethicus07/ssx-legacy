<?php

namespace App\Helpers;

use App\Models\HistoricalLog;

class HistoryLogHelper
{
    public static function log(
        $causer_ff_code,
        $fair_code,
        $target_ff_code,
        $process,
        $description
    ) {
        HistoricalLog::create([
            'causer_ff_code'  => $causer_ff_code,
            'fair_code'      => $fair_code,
            'target_ff_code' => $target_ff_code,
            'process'        => $process,
            'description'    => json_encode($description),
        ]);
    }
}
