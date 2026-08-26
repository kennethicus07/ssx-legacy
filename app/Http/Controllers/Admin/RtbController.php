<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\RtbGenerated;
use App\Models\Supplier\Event;
use App\Models\Supplier\ParticipationBoothSelection;
use App\Models\Supplier\AdditionalFees;
use App\Models\Supplier\Discounts;
use App\Models\Supplier\ParticipationMandatory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Helpers\RtbBatchHelper;
use App\Models\Conforme;
use ZipArchive;

class RtbController extends Controller
{
public function generate_rtb(Request $request)
{
    $ids = collect($request->ids)
        ->map(fn ($id) => (int) $id)
        ->unique()
        ->values()
        ->toArray();

    $fairCode = $request->fair_code;

    $venue = $request->venue ?? 'N/A';
    $eventDate = $request->event_date ?? 'N/A';

    $event = Event::where('fair_code', $fairCode)->firstOrFail();

    $attendances = ExhibitorAttendance::with([
        'user',
        'latestConforme' => function ($query) use ($fairCode) {
            $query->where('fair_code', $fairCode)
                ->latest('created_at');
        }
    ])
    ->whereIn('user_id', $ids)
    ->where('fair_code', $fairCode)
    ->get();

        if ($attendances->isEmpty()) {
            return response()->json(['message' => 'No valid records found'], 422);
        }

        $rows = [];
        $conformesData = [];

        foreach ($attendances as $attendance) {
            $user = $attendance->user;
            $exhibitor = $user->exhibitorForFair($fairCode);

            $currency = $this->getCurrency($exhibitor->business_type_id);

            $items = $this->buildRtbItems($user->id, $fairCode, $currency);

            $rows[] = [
                'subject' => 'REQUEST TO BILL',
                'project_name' => 'Sustainability Solutions Exchange 2026',
                'company' => $exhibitor->co_name ?? 'N/A',
                'items' => implode('<br>', $items),
                'notes' => 'SSX 2026 participation payment',
                'deadline' => '2 weeks from issuance of SOA',
                'ff_code' => $user->id,
                'venue' => $venue,
                'event_date' => $eventDate,
            ];

            $conformesData[] = $this->getLatestConforme($attendance->user_id, $fairCode);
        }

        // --- Generate RTB PDF ---
        $pdf = Pdf::loadView('pdf.rtb', [
            'event' => $event,
            'rows' => $rows,
            'venue' => $venue,
            'event_date' => $eventDate,
        ])->setPaper('a4', 'landscape');

        $filename = RtbBatchHelper::generateFileName($fairCode);
        $path = "rtb/{$filename}";
        Storage::disk('public')->put($path, $pdf->output());

        // --- Save RTB records ---
        foreach ($rows as $row) {
            RtbGenerated::create([
                'ff_code' => $row['ff_code'],
                'fair_code' => $fairCode,
                'rtb_file' => $path,
                'venue' => $venue,
                'event_date' => $eventDate,
            ]);
        }

        ExhibitorAttendance::whereIn('user_id', $ids)
            ->update(['is_rtb_generated' => true]);

        // --- Create ZIP with RTB + conformes ---
        $zipFilename = $this->createRtbConformesZip($path, $conformesData, $fairCode);

        return response()->json([
            'status' => 'success',
            'message' => 'RTB + Conformes ZIP generated successfully',
            'url' => asset("storage/rtb/{$zipFilename}"),
            'filename' => $zipFilename,
        ]);
    }

    // --- Private helpers ---

    private function getCurrency($businessTypeId)
    {
        $mandatory = ParticipationMandatory::where('business_type_id', $businessTypeId)->first();
        return $mandatory->currency ?? 'PHP';
    }

    private function buildRtbItems($userId, $fairCode, $currency)
    {
        $items = [];
        $cartTotal = ParticipationBoothSelection::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->sum('total_amount_due');

        $additionalFees = AdditionalFees::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->get();
        $additionalFeesTotal = $additionalFees->sum('amount');

        $discounts = Discounts::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->get();
        $discountTotal = $discounts->sum('amount');

        $estimatedTotal = $cartTotal + $additionalFeesTotal - $discountTotal;

        $items[] = "Cart Total: $currency " . number_format($cartTotal, 2);
        foreach ($additionalFees as $fee) {
            $items[] = "{$fee->remarks}: {$fee->currency} " . number_format($fee->amount, 2);
        }
        foreach ($discounts as $discount) {
            $items[] = "{$discount->remarks}: {$discount->currency} <span style='color:red;'>-</span>" . number_format($discount->amount, 2);
        }
        $items[] = "<strong>Estimated Total: $currency " . number_format($estimatedTotal, 2) . "</strong>";

        return $items;
    }

    private function getLatestConforme($userId, $fairCode)
    {
        $latestConforme = Conforme::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->where('response', 1) 
            ->latest('created_at')
            ->first();

        if ($latestConforme) {
            Log::info('Conforme found', [
                'ff_code' => $latestConforme->ff_code,
                'file'    => $latestConforme->noa_file,
                'url'     => asset('storage/' . $latestConforme->noa_file),
            ]);
            return [
                'ff_code' => $latestConforme->ff_code,
                'fair_code' => $latestConforme->fair_code,
                'file' => $latestConforme->noa_file,
                'created_at' => $latestConforme->created_at,
                'url' => asset('storage/' . $latestConforme->noa_file),
                'exists' => true,
            ];
        } else {
            Log::warning("No approved conforme found for user {$userId} and fair {$fairCode}");
            return [
                'ff_code' => $userId,
                'fair_code' => $fairCode,
                'file' => null,
                'created_at' => null,
                'url' => null,
                'exists' => false,
            ];
        }
    }

    private function createRtbConformesZip($rtbPath, $conformesData, $fairCode)
    {
        $zipFilename = "RTB_Conformes_{$fairCode}_" . time() . ".zip";
        $zipPath = storage_path("app/public/rtb/{$zipFilename}");
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Add RTB PDF
            $zip->addFile(storage_path("app/public/{$rtbPath}"), basename($rtbPath));

            // Add conformes
            foreach ($conformesData as $c) {
                if ($c['exists'] && file_exists(storage_path('app/public/' . $c['file']))) {
                    $zip->addFile(storage_path('app/public/' . $c['file']), basename($c['file']));
                }
            }

            $zip->close();
        }

        return $zipFilename;
    }
}