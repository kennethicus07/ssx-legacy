<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\ExhibitorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ExhibitorPaymentController extends Controller
{
public function store(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:exhibitor_attendance,id',
        'payment_file' => 'nullable', // new files
        'deleted_ids' => 'nullable|array', // IDs of files to delete
        'deleted_ids.*' => 'integer|exists:exhibitor_payments,id',
    ]);

    $attendance = ExhibitorAttendance::findOrFail($request->attendance_id);

    // --- BLOCK ANY CHANGES IF payment_status is Pending or Paid ---
    if ($attendance->payment_status === ExhibitorAttendance::PAYMENT_PENDING ||
        $attendance->payment_status === ExhibitorAttendance::PAYMENT_PAID
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Payment files cannot be modified. Status is Pending or Paid.',
            'attendance' => $attendance,
        ], 403);
    }

    // --- 1️⃣ Handle deleted files (allowed only if UNPAID) ---
    $deletedIds = $request->input('deleted_ids', []);
    if (!empty($deletedIds)) {
        $paymentsToDelete = ExhibitorPayment::whereIn('id', $deletedIds)->get();

        foreach ($paymentsToDelete as $payment) {
            // Delete physical file if exists
            if (Storage::disk('public')->exists($payment->payment_file)) {
                Storage::disk('public')->delete($payment->payment_file);
            }
            // Delete record from DB
            $payment->delete();
        }
    }

    // --- 2️⃣ Handle new uploaded files (allowed only if UNPAID) ---
    $files = $request->file('payment_file');
    $payments = [];

    if ($files) {
        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            if (!$file) continue;

            validator(['file' => $file], [
                'file' => 'file|max:2048|mimes:jpg,jpeg,png,pdf',
            ])->validate();

            $path = $file->store('payments', 'public');

            $payment = ExhibitorPayment::create([
                'ff_code' => $attendance->user_id,
                'fair_code' => $attendance->fair_code,
                'payment_file' => $path,
                'created_by' => $attendance->user_id,
                'created_at' => now(),
            ]);

            $payments[] = $payment;
        }
    }

    // --- 3️⃣ Update status only if previously UNPAID ---
    if (is_null($attendance->payment_status) || $attendance->payment_status === ExhibitorAttendance::PAYMENT_UNPAID) {
        $attendance->payment_status = ExhibitorAttendance::PAYMENT_PENDING;
        $attendance->save();
    } else {
        $attendance->touch();
    }

    // --- 4️⃣ Return all payments for this attendance ---
    $allPayments = ExhibitorPayment::where('ff_code', $attendance->user_id)
        ->where('fair_code', $attendance->fair_code)
        ->get();

    return response()->json([
        'success' => true,
        'message' => 'Payment updated successfully.',
        'payments' => $this->mapPayments($allPayments),
        'attendance' => $attendance,
    ]);
}

    public function getLatestPayment(Request $request)
    {
        $request->validate([
            'ff_code' => 'required|integer|exists:users,id',
            'fair_code' => 'required|string',
        ]);

        $payments = ExhibitorPayment::where('ff_code', $request->ff_code)
            ->where('fair_code', $request->fair_code)
            ->orderByDesc('created_at')
            ->get();

        if ($payments->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No payment found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'payments' => $this->mapPayments($payments),
        ]);
    }

    /**
     * 🔥 CENTRALIZED SAFE MAPPING (NO MORE CRASH)
     */
private function mapPayments($payments)
{
    return collect($payments)->map(function ($payment) {
        $filePath = $payment->payment_file;

        $exists = Storage::disk('public')->exists($filePath);

        $mimeType = null;

        if ($exists) {
            try {
                $mimeType = Storage::mimeType('public/' . $filePath);
            } catch (\Exception $e) {
                $mimeType = null;
            }
        }

        return [
            'id' => $payment->id,
            'name' => basename($filePath),
            'url' => $exists ? Storage::url($filePath) : null,
            'size' => $exists ? Storage::disk('public')->size($filePath) : 0,
            'type' => $mimeType, // ✅ FIXED HERE
            'remote' => true,
            'created_at' => $payment->created_at,
            'created_by' => $payment->created_by,
        ];
    })->values();
}
}