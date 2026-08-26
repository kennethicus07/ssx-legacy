<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OfficerPaymentNotification;
use App\Mail\OfficerSoaGeneratedNotification;
use App\Mail\SupplierSoaSentNotfication;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\ExhibitorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

class PaymentController extends Controller
{

private function parseEmailList($value)
{
if (!$value) {
    return [];
}

// Convert comma-separated string into array
$emails = is_array($value) ? $value : explode(',', $value);

// Trim & filter
return array_values(array_filter(array_map('trim', $emails)));
}

   public function supplier_index(){
        return view('admin.payments.supplier.index');
    }

    

public function supplier_view($user_id, $slug, $fair_code)
{
    // Get the event
    $event = Event::where('slug', $slug)->firstOrFail();

    // Get the attendance using user_id and fair_code
    $attendance = ExhibitorAttendance::where('user_id', $user_id)
        ->where('fair_code', $fair_code)
        ->first();

    // Restrict access if attendance doesn't exist or SOA not generated
    if (!$attendance || !$attendance->is_soa_generated) {
        return redirect()->route('supplier.payments.events.index')
            ->with('error', 'Attendance not found or SOA not generated.');
    }

    return view('admin.payments.supplier.view', compact('attendance', 'event'));
}

public function supplier_store(Request $request)
{
    $request->validate([
        'attendance_id' => 'required|exists:exhibitor_attendance,id',
        'payment_file' => 'nullable', // new files
        'deleted_ids' => 'nullable|array', // IDs of files to delete
        'deleted_ids.*' => 'integer|exists:exhibitor_payments,id',
    ]);

    $attendance = ExhibitorAttendance::findOrFail($request->attendance_id);

    

    // --- 1️⃣ Handle deleted files (allowed only if UNPAID ---
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
                
            
            ]);

            $payments[] = $payment;
        }
    }

  
        $attendance->save();

        $attendance->touch();
    

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

public function getSupplierPayment(Request $request)
{
    $attendance = ExhibitorAttendance::with(['event', 'exhibitor'])
        ->where('user_id', $request->user_id)
        ->where('fair_code', $request->fair_code)
        ->first();

    if (!$attendance) {
        return response()->json([
            'success' => false,
            'message' => 'Attendance not found'
        ], 404);
    }

        $arr_permissions = [
        'can_upload' => Auth::user()->can('upload payments'),
        'can_update' => Auth::user()->can('update payments'),
    ];

    return response()->json([
        'success' => true,
        'attendance' => $attendance,
        'event' => $attendance->event, 
        'exhibitor' => $attendance->exhibitor,
        'permissions' => $arr_permissions,
    ]);
}

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
            'type' => $mimeType, 
            'remote' => true,
            'created_at' => $payment->created_at,
            'created_by' => $payment->created_by,
        ];
    })->values();
}


public function markSOA(Request $request)
{
    $request->validate([
        'updates' => 'required|array|min:1',
        'updates.*.id' => [
            'required',
            'integer',
            Rule::exists('exhibitor_attendance', 'user_id')
                ->where('fair_code', $request->fair_code),
        ],
        'updates.*.new_status' => 'required|boolean',
        'fair_code' => 'required|string',
    ]);

    $updates = $request->updates;
    $fairCode = $request->fair_code;

    try {
        $emailsToSend = [];

        DB::transaction(function () use ($updates, $fairCode, &$emailsToSend) {

            foreach ($updates as $item) {

                $newStatus = (int) $item['new_status'];

                $attendance = ExhibitorAttendance::where('user_id', $item['id'])
                    ->where('fair_code', $fairCode)
                    ->firstOrFail();

                $attendance->is_soa_generated = $newStatus;
                $attendance->soa_by = auth()->id();
                $attendance->soa_at = now();
                $attendance->save();

                Log::info("SOA updated", [
                    'user_id' => $attendance->user_id,
                    'fair_code' => $fairCode,
                    'new_status' => $newStatus
                ]);

                // Collect for user emails if generated
                if ($newStatus === 1) {
                    $emailsToSend[] = $attendance;
                }
            }
        });

        // --- Send email to individual users ---
        foreach ($emailsToSend as $attendance) {
            $user = $attendance->user;

            if (!$user || !$user->email) {
                Log::warning('Missing email for user_id: ' . $attendance->user_id);
                continue;
            }

            $mail = new SupplierSoaSentNotfication($user, $attendance, $fairCode);

            try {
                if (app()->environment('local')) {
                    Mail::to('kgtecson.citem@gmail.com')->send($mail);
                } else {
                    Mail::to($user->email)->send($mail);
                }

                Log::info('SOA email sent', [
                    'email' => $user->email,
                    'user_id' => $attendance->user_id
                ]);

            } catch (\Throwable $mailError) {
                Log::error('SOA email failed', [
                    'email' => $user->email ?? null,
                    'error' => $mailError->getMessage()
                ]);
            }
        }

        // --- Send a single email to BCC officers listing all generated SOAs ---
        if (!empty($emailsToSend)) {

            // Parse BCC list from env
            $bcc = $this->parseEmailList(env('BCC_Officer_Suppliers'));

            $officerMail = new OfficerSoaGeneratedNotification($emailsToSend, $fairCode);

            try {
                if (app()->environment('local')) {
                    Mail::to('kgtecson.citem@gmail.com')
                        ->bcc($bcc)
                        ->send($officerMail);
                } else {
                    Mail::to($bcc[0] ?? null) // pick first as "to" if required
                        ->bcc($bcc)
                        ->send($officerMail);
                }

                Log::info('Officer SOA email sent', [
                    'bcc' => $bcc,
                    'count' => count($emailsToSend)
                ]);

            } catch (\Throwable $mailError) {
                Log::error('Officer SOA email failed', [
                    'error' => $mailError->getMessage()
                ]);
            }
        }

        return response()->json([
            'message' => 'SOA status updated successfully.',
        ]);

    } catch (\Throwable $e) {

        Log::error('SOA update failed', [
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'message' => 'Failed to update SOA status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


public function markStatus(Request $request) {
    $attendance = ExhibitorAttendance::where('user_id', $request->attendance_id)
        ->where('fair_code', $request->fair_code)
        ->firstOrFail(); 

    $attendance->payment_status = $request->status; 
    $attendance->payment_review_by = Auth::id(); 
    $attendance->payment_review_date = Date::now(); 
    $attendance->touch(); 
    $attendance->save(); 

    // ✅ Send email if payment is marked as PAID
    if ($attendance->payment_status == ExhibitorAttendance::PAYMENT_PAID) {
        // Collect the single attendance into a collection (or array)
        $attendances = collect([$attendance]);

        // Parse BCC list from env
        $bcc = array_merge(
            $this->parseEmailList(env('BCC_Officer_Suppliers'))
        );

        try {
            if (app()->environment('local')) {
                Mail::to('kgtecson.citem@gmail.com')->send(new OfficerPaymentNotification($attendances));
            } else {
                Mail::to('sustainabilityph@citem.com.ph') // or primary recipient if needed
                    ->bcc($bcc)
                    ->send(new OfficerPaymentNotification($attendances));
            }
        } catch (Throwable $e) {
            Log::error('Officer Payment email failed', [
                'attendance_id' => $attendance->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    return response()->json([ 
        'success' => true, 
        'attendance' => $attendance, 
        'message' => 'Payment status updated.', 
    ]); 
}
}
