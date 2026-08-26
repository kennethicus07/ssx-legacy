<?php

namespace App\Enums;

class SalesTypeStatus
{
    const EXPORT = 1;
    const DOMESTIC = 2;
    const RETAIL = 3;

    public static function label($value): string
    {
        switch ($value) {
            case self::EXPORT:
                return 'Export';

            case self::DOMESTIC:
                return 'Domestic';

            case self::RETAIL:
                return 'Retail';

            default:
                return '';
        }
    }

    public static function options(): array
    {
        return [
            [
                'value' => self::EXPORT,
                'label' => 'Export',
            ],
            [
                'value' => self::DOMESTIC,
                'label' => 'Domestic',
            ],
            [
                'value' => self::RETAIL,
                'label' => 'Retail',
            ],
        ];
    }
}