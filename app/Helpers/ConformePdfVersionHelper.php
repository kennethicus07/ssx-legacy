<?php

namespace App\Helpers;

use App\Models\Conforme;

class ConformePdfVersionHelper
{
    /**
     * db query
     */
    public static function getNextVersionNumber(int $userId, string $fairCode): int
    {
        // Fetch all pdf user & fair_code
        $latest = Conforme::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->selectRaw("MAX(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(noa_file, '_', 3), '_', -1) AS UNSIGNED)) as version")
            ->first();

        $currentVersion = $latest->version ?? 0;

        return $currentVersion + 1;
    }

    /**
     * Format version number  (01, 02, 10, 100...)
     */
    public static function formatVersion(int $version): string
    {
        return str_pad($version, 2, '0', STR_PAD_LEFT);
    }
}
