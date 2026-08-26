<?php

namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeHelper
{
    public static function generate(
        string $token,
        string $fileName
    ): string {
        $directory = storage_path('app/public/conference/qr');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filePath = $directory . '/' . $fileName;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($token)
            ->size(500)
            ->margin(10)
            ->build();

        $result->saveToFile($filePath);

        return $filePath;
    }
}