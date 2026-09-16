<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer\BuyerAttendance;
use App\Models\Buyer;
use App\Models\Countries;
use App\Helpers\QRCodeHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuyerController extends Controller
{
    public function generateQr($userId, $fairCode)
    {
      
        $attendance = BuyerAttendance::where('user_id', $userId)
            ->where('fair_code', $fairCode)
            ->where('status', 1)
            ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'Approved buyer attendance not found.'
            ], 404);
        }
     
        $buyer = Buyer::where('uid', $userId)
            ->where('fair_code', $fairCode)
            ->first();

        if (!$buyer) {
            return response()->json([
                'message' => 'Buyer registration not found for this fair.'
            ], 404);
        }

        $country = Countries::find($buyer->country);
        $countryName = $country ? $country->name : '';
   
        if (!empty($attendance->qr_file)) {
            $oldQrPath = 'buyer/qr/' . $attendance->qr_file;
            if (Storage::disk('public')->exists($oldQrPath)) {
                Storage::disk('public')->delete($oldQrPath);
            }
        }
   
        $attendance->qr_token = Str::random(32);
        $fileName = 'buyer_' . $attendance->id . '.png';
        $firstName = trim($buyer->fname ?? '');
        $middleName = trim($buyer->mi ?? '');
        $lastName = trim($buyer->lname ?? '');
        $fullName = trim(
            $firstName . ' ' .
            $middleName . ' ' .
            $lastName
        );
     
        $vCard = "BEGIN:VCARD\r\n";
        $vCard .= "FN:" . $firstName . "\r\n";
        $vCard .= "MI:" . $middleName . "\r\n";
        $vCard .= "LN:" . $lastName . "\r\n";
        if (!empty($buyer->email)) {
            $vCard .= "EMAIL:" . $buyer->email . "\r\n";
        }
        if (!empty($buyer->co_name)) {
            $vCard .= "ORG:" . $buyer->co_name . "\r\n";
        }
        if (!empty($countryName)) {
            $vCard .= "ADR:" . $countryName . "\r\n";
        }
        $vCard .= "VRS:SSX\r\n";
        $vCard .= "STATUS:NEW\r\n";
        $vCard .= "VTYPE:TRADE BUYER\r\n";
        $vCard .= "RCODE:" . $buyer->uid . "\r\n";
        $vCard .= "END:VCARD\r\n";
     
        QRCodeHelper::generate(
            $vCard,
            $fileName,
            'buyer/qr'
        );

        $attendance->qr_file = $fileName;
        $attendance->save();

        return response()->json([
            'message' => 'Buyer QR code generated successfully.',
            'buyer' => [
                'id' => $buyer->id,
                'uid' => $buyer->uid,
                'fair_code' => $buyer->fair_code,
                'co_name' => $buyer->co_name,
                'co_email' => $buyer->co_email,
                'name' => $fullName,
            ],
            'qr_file' => $attendance->qr_file,
            'qr_token' => $attendance->qr_token,
            'vcard' => $vCard,
        ]);
    }
}