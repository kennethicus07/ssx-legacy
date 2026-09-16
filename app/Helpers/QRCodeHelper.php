<?php

namespace App\Helpers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeHelper
{
    public static function generate(
        string $data,
        string $fileName,
        string $directory = 'conference/qr'
    ): string {
        $path = storage_path('app/public/' . $directory);

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filePath = $path . '/' . $fileName;

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($data)
            ->size(500)
            ->margin(10)
            ->build();

        $result->saveToFile($filePath);

        return $filePath;
    }
}