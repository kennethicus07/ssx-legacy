<?php

namespace App\Helpers;

use App\Models\Buyer\BuyerAttendance;
use App\Models\Supplier\ExhibitorAttendance;
use Illuminate\Support\Str;
use App\Models\SSXConferenceDelegate;

class QRTokenHelper
{
    public const TYPE_SUPPLIER = 'supplier';
    public const TYPE_BUYER = 'buyer';
    public const TYPE_DELEGATE = 'delegate';
    public const TYPE_DEFAULT = 'default';


    public static function generateToken(
        string $type = self::TYPE_DEFAULT
    ): string {
        do {
            $token = Str::random(32);
        } while (self::tokenExists($token, $type));

        return $token;
    }

    private static function tokenExists(
        string $token,
        string $type
    ): bool {
        switch ($type) {

            case self::TYPE_BUYER:
                return BuyerAttendance::where(
                    'qr_token',
                    $token
                )->exists();

            case self::TYPE_SUPPLIER:
                return ExhibitorAttendance::where(
                    'qr_token',
                    $token
                )->exists();

            case self::TYPE_DELEGATE:
                return SSXConferenceDelegate::where(
                    'qr_token',
                    $token
                )->exists();

            case self::TYPE_DEFAULT:
            default:
                return false;
        }
    }
}