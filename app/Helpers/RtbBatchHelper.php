<?php

namespace App\Helpers;

use App\Models\Supplier\RtbGenerated;

class RtbBatchHelper
{
    /**
     * Get next batch version per fair_code
     */
    public static function getNextBatchVersion(string $fairCode): int
    {
        $latest = RtbGenerated::where('fair_code', $fairCode)
            ->selectRaw("
                MAX(
                    CAST(
                        SUBSTRING_INDEX(
                            SUBSTRING_INDEX(rtb_file, '_v', -1),
                            '_',
                            1
                        ) AS UNSIGNED
                    )
                ) as version
            ")
            ->first();

        $currentVersion = $latest->version ?? 0;

        return $currentVersion + 1;
    }

    /**
     * Format version (01, 02, 10...)
     */
    public static function formatVersion(int $version): string
    {
        return str_pad($version, 2, '0', STR_PAD_LEFT);
    }

    /**
     * Generate short hash
     */
public static function generateHash(int $length = 12): string
{
    return substr(bin2hex(random_bytes(16)), 0, $length);
}

    /**
     * Generate filename
     */
public static function generateFileName(string $fairCode): string
{
    $version = self::getNextBatchVersion($fairCode);
    $formattedVersion = self::formatVersion($version);

    $date = now()->format('Ymd');

    $hash1 = self::generateHash(12);
    $hash2 = self::generateHash(12);

    return "rtb_{$fairCode}_v{$formattedVersion}_{$date}_{$hash1}_{$hash2}.pdf";
}
}