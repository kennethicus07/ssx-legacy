<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Mail\ExhibitorEmailRegistrationValidation;
use App\Mail\BuyerEmailRegistrationValidation;
use App\Mail\SupplierConformeValidation;
use App\Mail\ApprovedApplication;
use App\Mail\DeniedApplication;
use App\Mail\OnHoldApplication;
use App\Models\Certification;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\NatureBusiness;
use App\Models\TargetBuyer;
use App\Models\AboutEvent;
use App\Models\Buyer;
use App\Models\Buyer\BuyerAttendance;
use App\Models\Exhibitor;
use App\Models\Conforme;
use App\Models\ParticipationGoal;
use App\Models\Supplier\AdditionalFees;
use App\Models\Supplier\Discounts;
use App\Models\HistoricalLog;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\ParticipationAddOnSelection;
use App\Models\Supplier\ParticipationMandatory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Helpers\HistoryLogHelper;
use App\Mail\BuyerApprovedApplication;
use App\Mail\RevertToIncomplete;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Image;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{


    private function generateToken($user)
{
    return hash(
        'sha256',
        $user->id . '|' . microtime(true) . '|' . bin2hex(random_bytes(16))
    );
}

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

    /* Get next PDF version number
     */
    private function getNextPdfVersionNumber(int $userId, string $fairCode): int
    {
        $latest = Conforme::where('ff_code', $userId)
            ->where('fair_code', $fairCode)
            ->selectRaw("
                MAX(
                    CAST(
                        SUBSTRING_INDEX(
                            SUBSTRING_INDEX(noa_file, '_', 3),
                            '_',
                            -1
                        ) AS UNSIGNED
                    )
                ) as version
            ")
            ->first();

        return ((int) ($latest->version ?? 0)) + 1;
    }

    /**
     * Format version number (01, 02, 10, 100…)
     */
private function formatPdfVersion(int $version): string
{
    return str_pad($version, 2, '0', STR_PAD_LEFT);
}

public function suppliers()
{
    return view('admin.registration.supplier.index');
}

public function buyers()
{
    return view('admin.registration.buyer.index');
}


    public function conference()
{
    return view('admin.registration.conference.index');
}

    public function sponsorship()
{
    return view('admin.registration.sponsorship.index');
}


private function logHistory($actorUserId, $fairCode,  $target_ff_code, $process, $description)
{
    HistoricalLog::create([
        'ff_code'   => $actorUserId,
        'fair_code' => $fairCode,
        'target_ff_code' => $target_ff_code,
        'process'   => $process,   
        'old_data'  => $description,

    ]);
}

// No Pending Conforme Generation
// public function list(Request $request)
// {
//     $per_page = $request->input('per_page', 10);
//     $page = $request->input('page', 1);
//     $offset = ($page - 1) * $per_page;

//     $filters = $request->has('filter') ? json_decode($request->input('filter'), true) : [];
//     $fair_code = $filters['fair_code'] ?? null;

//  // --- Determine fair_code ---
//     $fair_code = $filters['fair_code'] ?? null;
//     if (!$fair_code) {
//         // Get latest event's fair_code
//         $latestEvent = Event::latest()->first();
//         $fair_code = $latestEvent ? $latestEvent->fair_code : null;
//         $filters['fair_code'] = $fair_code; // so filtering logic below uses it
//     }

//     // Base query per Exhibitor
//     $exhibitors = Exhibitor::with([
//         'user',
//         'reviewer',
//         'approver',
//         'disapprover',
//         'onholder',
//         'attendances', 
//     ])   ->whereHas('user', function ($q) {
//         $q->where('user_group', 5);
//     });

//     // --- Filters ---
//     if (!empty($filters)) {
//         if (!empty($filters['co_name'])) {
//             $exhibitors->where('co_name', 'like', '%'.$filters['co_name'].'%');
//         }

//         if (!empty($filters['co_email'])) {
//             $exhibitors->where('co_email', $filters['co_email']);
//         }

//         if (!empty($filters['fair_code'])) {
//             $exhibitors->where('fair_code', $filters['fair_code']);
//         }

//         if (isset($filters['status']) && $filters['status'] !== '') {
//             $status = $filters['status'];

//             $exhibitors->where(function ($query) use ($status, $fair_code) {
//               if ($status === 'incomplete') {
//     $query->whereDoesntHave('attendances', function ($q) use ($fair_code) {
//         if ($fair_code) {
//             $q->where('fair_code', $fair_code)
//               ->where('status', '>', 0); // Only exclude buyers with status > 0
//         } else {
//             $q->where('status', '>', 0);
//         }
//     });
// }

//             });
//         }
//     }

//     // --- Sorting ---
//     if ($request->has('sort')) {
//         $sort = json_decode($request->input('sort'), true);
//         if (!in_array($sort['field'], ['co_name', 'co_email', 'fair_code'])) {
//             $exhibitors->orderBy($sort['field'], $sort['type']);
//         }
//     }

//     $total_exhibitors = $exhibitors->count();

//     // --- Fetch paginated results ---
//     $records = $exhibitors->offset($offset)
//         ->limit($per_page)
//         ->get()
//         ->map(function ($exhibitor) use ($fair_code) {
//              $attendance = $fair_code 
//             ? $exhibitor->attendances->firstWhere('fair_code', $fair_code) 
//             :  $exhibitor->attendances->firstWhere('fair_code', $exhibitor->fair_code);

//             $exhibitor->status = $attendance->status ?? 0;
//             $exhibitor->registration_agreed_at = $attendance->registration_agreed_at ?? null;
//             $exhibitor->user_name = $exhibitor->user->name ?? null;
//                $exhibitor->id = $exhibitor->uid;
//             return $exhibitor;
//         });

//     $arr_permissions = [
//         'can_view' => Auth::user()->can('view reg_suppliers'),
//         'can_resend' => Auth::user()->can('resend reg_suppliers'),
//         'can_approved' => Auth::user()->can('approve reg_suppliers'),
//         'can_review' => Auth::user()->can('review reg_suppliers'),
//         'can_hold' => Auth::user()->can('onhold reg_suppliers'),
//         'can_deny' => Auth::user()->can('disapprove reg_suppliers'),
//         'can_edit' => Auth::user()->can('edit reg_suppliers'),
//         'can_add' => Auth::user()->can('add reg_suppliers'),
//     ];

//     return response()->json([
//         'total' => $total_exhibitors,
//         'data' => $records,
//         'permissions' => $arr_permissions
//     ], 200);
// }



public function conference_list(Request $request)
{
    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $filters = $request->has('filter') ? json_decode($request->input('filter'), true) : [];
    $fair_code = $filters['fair_code'] ?? null;

 // --- Determine fair_code ---
    $fair_code = $filters['fair_code'] ?? null;
    if (!$fair_code) {
        // Get latest event's fair_code
        $latestEvent = Event::latest()->first();
        $fair_code = $latestEvent ? $latestEvent->fair_code : null;
        $filters['fair_code'] = $fair_code; // so filtering logic below uses it
    }

    // Base query per Exhibitor
    $exhibitors = Exhibitor::with([
        'user',
        'reviewer',
        'approver',
        'disapprover',
        'onholder',
        'attendances', 
    ])   ->whereHas('user', function ($q) {
        $q->where('user_group', 5);
    });

    // --- Filters ---
    if (!empty($filters)) {
        if (!empty($filters['co_name'])) {
            $exhibitors->where('co_name', 'like', '%'.$filters['co_name'].'%');
        }

        if (!empty($filters['co_email'])) {
            $exhibitors->where('co_email', $filters['co_email']);
        }

        if (!empty($filters['fair_code'])) {
            $exhibitors->where('fair_code', $filters['fair_code']);
        }

         /**
         * ALWAYS show only records WITH conference_response (0 or 1)
         */
        $exhibitors->whereHas('attendances', function ($q) use ($fair_code) {
            if ($fair_code) {
                $q->where('fair_code', $fair_code);
            }

            $q->whereIn('conference_response', [0, 1]);
        });

        

if (isset($filters['status']) && $filters['status'] !== '') {
    $status = $filters['status'];

    $exhibitors->where(function ($q) use ($status, $fair_code) {
        switch ((int)$status) { // cast to int
            case ExhibitorAttendance::STATUS_INCOMPLETE: // 0
                $q->whereDoesntHave('attendances', fn($qq) => 
                    $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                       ->where('status', '>', 0)
                );
                break;

            case ExhibitorAttendance::STATUS_PENDING_CONFORME_GENERATION: // 1
            case ExhibitorAttendance::STATUS_PENDING: // 2
            case ExhibitorAttendance::STATUS_REVIEWED: // 3
            case ExhibitorAttendance::STATUS_ONHOLD: // 4
            case ExhibitorAttendance::STATUS_DENIED: // 5
                $q->whereHas('attendances', fn($qq) => 
                    $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                       ->where('status', $status)
                );
                break;

            case 6: // For RTB
                $q->whereHas('attendances', fn($qq) =>
                    $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                       ->where('status', ExhibitorAttendance::STATUS_PENDING_CONFORME_GENERATION)
                       ->where('conforme_review', 1)
                );
                break;

            case 7: // Awaiting Conforme
                $q->whereHas('attendances', fn($qq) =>
                    $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                       ->where('status', ExhibitorAttendance::STATUS_PENDING_CONFORME_GENERATION)
                       ->where(function($q2){
                           $q2->where('conforme_review', 0)
                              ->orWhereDoesntHave('conformes');
                       })
                );
                break;
        }
    });
}


// Participation Type filter (from exhibitor_attendances)
if (
    isset($filters['participation_type']) &&
    $filters['participation_type'] !== ''
) {
    $exhibitors->whereHas('attendances', function ($q) use ($filters, $fair_code) {
        if ($fair_code) {
            $q->where('fair_code', $fair_code);
        }

        $q->where(
            'participation_type',
            (int) $filters['participation_type']
        );
    });
}

// Conference Response filter (YES / NO)
if (
    array_key_exists('conference_response', $filters) &&
    $filters['conference_response'] !== '' &&
    $filters['conference_response'] !== null
) {
    $exhibitors->whereHas('attendances', function ($q) use ($filters, $fair_code) {
        if ($fair_code) {
            $q->where('fair_code', $fair_code);
        }

        $q->where(
            'conference_response',
            (int) $filters['conference_response']
        );
    });
}


    }

    // --- Sorting ---
    if ($request->has('sort')) {
        $sort = json_decode($request->input('sort'), true);
        if (!in_array($sort['field'], ['co_name', 'co_email', 'fair_code'])) {
            $exhibitors->orderBy($sort['field'], $sort['type']);
        }
    }

    $total_exhibitors = $exhibitors->count();

    // --- Fetch paginated results ---
    $records = $exhibitors->offset($offset)
    ->limit($per_page)
    ->get()
    ->map(function ($exhibitor) use ($fair_code) {
        $attendance = $fair_code 
            ? $exhibitor->attendances->firstWhere('fair_code', $fair_code) 
            : $exhibitor->attendances->firstWhere('fair_code', $exhibitor->fair_code);

        $exhibitor->status = $attendance->status ?? 0;
        $exhibitor->conforme_review = $attendance->conforme_review ?? 0;
        $exhibitor->registration_agreed_at = $attendance->registration_agreed_at ?? null;

        // ✅ NEW FIELDS
        $participationType = $attendance->participation_type ?? null;
        $conferenceResponse = $attendance->conference_response ?? null;

        $exhibitor->participation_type_label =
            $participationType === 1 ? 'Individual' :
            ($participationType === 2 ? 'Group' : null);

        $exhibitor->conference_response_label =
            $conferenceResponse === 1 ? 'Yes' :
            ($conferenceResponse === 0 ? 'No' : null);


        $exhibitor->user_name = $exhibitor->user->name ?? null;
        $exhibitor->id = $exhibitor->uid;

        // --- Display status logic (unchanged) ---
        if ($exhibitor->status == 0) {
            $exhibitor->display_status = 'Incomplete';
        } elseif ($exhibitor->status == 2) {
            $exhibitor->display_status = 'Pending';
        } elseif ($exhibitor->status == 3) {
            $exhibitor->display_status = 'Reviewed';
        } elseif ($exhibitor->status == 4) {
            $exhibitor->display_status = 'Onhold';
        } elseif ($exhibitor->status == 5) {
            $exhibitor->display_status = 'Denied';
        } elseif ($exhibitor->status == 1 && !$exhibitor->conforme_review) {
            $exhibitor->display_status = 'Pending Conforme Generation';
        } elseif ($exhibitor->status == 1 && $exhibitor->conforme_review == 1) {
            $exhibitor->display_status = 'Approved';
        } else {
            $exhibitor->display_status = 'Unknown';
        }

        return $exhibitor;
    });



    $arr_permissions = [
        'can_view' => Auth::user()->can('view reg_suppliers'),
        'can_resend' => Auth::user()->can('resend reg_suppliers'),
        'can_approved' => Auth::user()->can('approve reg_suppliers'),
        'can_review' => Auth::user()->can('review reg_suppliers'),
        'can_hold' => Auth::user()->can('onhold reg_suppliers'),
        'can_deny' => Auth::user()->can('disapprove reg_suppliers'),
        'can_edit' => Auth::user()->can('edit reg_suppliers'),
        'can_add' => Auth::user()->can('add reg_suppliers'),
    ];

    return response()->json([
        'total' => $total_exhibitors,
        'data' => $records,
        'permissions' => $arr_permissions
    ], 200);
}

public function sponsorship_list(Request $request)
{
    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $filters = $request->has('filter') ? json_decode($request->input('filter'), true) : [];
    $fair_code = $filters['fair_code'] ?? null;

 // --- Determine fair_code ---
    $fair_code = $filters['fair_code'] ?? null;
    if (!$fair_code) {
        // Get latest event's fair_code
        $latestEvent = Event::latest()->first();
        $fair_code = $latestEvent ? $latestEvent->fair_code : null;
        $filters['fair_code'] = $fair_code; // so filtering logic below uses it
    }

    // Base query per Exhibitor
    $exhibitors = Exhibitor::with([
        'user',
        'reviewer',
        'approver',
        'disapprover',
        'onholder',
        'attendances', 
    ])   ->whereHas('user', function ($q) {
        $q->where('user_group', 5);
    });

    // --- Filters ---
    if (!empty($filters)) {
        if (!empty($filters['co_name'])) {
            $exhibitors->where('co_name', 'like', '%'.$filters['co_name'].'%');
        }

        if (!empty($filters['co_email'])) {
            $exhibitors->where('co_email', $filters['co_email']);
        }

        if (!empty($filters['fair_code'])) {
            $exhibitors->where('fair_code', $filters['fair_code']);
        }

         /**
         * ALWAYS show only records WITH sponsorship_response (0 or 1)
         */
        $exhibitors->whereHas('attendances', function ($q) use ($fair_code) {
            if ($fair_code) {
                $q->where('fair_code', $fair_code);
            }

            $q->whereIn('sponsorship_response', [0, 1]);
        });

        

        if (isset($filters['status']) && $filters['status'] !== '') {
        $status = $filters['status'];

    $exhibitors->where(function ($query) use ($status, $fair_code) {
        switch ($status) {
            case 'incomplete':
                $query->whereDoesntHave('attendances', function ($q) use ($fair_code) {
                    if ($fair_code) {
                        $q->where('fair_code', $fair_code)
                          ->where('status', '>', 0);
                    } else {
                        $q->where('status', '>', 0);
                    }
                });
                break;

            case 'pending_conforme_generation':
                $query->whereHas('attendances', function ($q) use ($fair_code) {
                    if ($fair_code) {
                        $q->where('fair_code', $fair_code)
                          ->where('status', 1)
                          ->where('conforme_review', 0);
                    } else {
                        $q->where('status', 0)
                          ->where('conforme_review', 0);
                    }
                });
                break;

            case 'approved':
                $query->whereHas('attendances', function ($q) use ($fair_code) {
                    if ($fair_code) {
                        $q->where('fair_code', $fair_code)
                          ->where('status', 1)
                          ->where('conforme_review', 1);
                    } else {
                        $q->where('status', 1)
                          ->where('conforme_review', 1);
                    }
                });
                break;

            default:
                // For statuses 2,3,4,5 just filter by status
                $query->whereHas('attendances', function ($q) use ($fair_code, $status) {
                    if ($fair_code) {
                        $q->where('fair_code', $fair_code)
                          ->where('status', $status);
                    } else {
                        $q->where('status', $status);
                    }
                });
        }
    });
}


// Participation Type filter (from exhibitor_attendances)
if (
    isset($filters['participation_type']) &&
    $filters['participation_type'] !== ''
) {
    $exhibitors->whereHas('attendances', function ($q) use ($filters, $fair_code) {
        if ($fair_code) {
            $q->where('fair_code', $fair_code);
        }

        $q->where(
            'participation_type',
            (int) $filters['participation_type']
        );
    });
}

// Sponsorship Response filter (YES / NO)
if (
    array_key_exists('sponsorship_response', $filters) &&
    $filters['sponsorship_response'] !== '' &&
    $filters['sponsorship_response'] !== null
) {
    $exhibitors->whereHas('attendances', function ($q) use ($filters, $fair_code) {
        if ($fair_code) {
            $q->where('fair_code', $fair_code);
        }

        $q->where(
            'sponsorship_response',
            (int) $filters['sponsorship_response']
        );
    });
}


    }

    // --- Sorting ---
    if ($request->has('sort')) {
        $sort = json_decode($request->input('sort'), true);
        if (!in_array($sort['field'], ['co_name', 'co_email', 'fair_code'])) {
            $exhibitors->orderBy($sort['field'], $sort['type']);
        }
    }

    $total_exhibitors = $exhibitors->count();

    // --- Fetch paginated results ---
    $records = $exhibitors->offset($offset)
    ->limit($per_page)
    ->get()
    ->map(function ($exhibitor) use ($fair_code) {
        $attendance = $fair_code 
            ? $exhibitor->attendances->firstWhere('fair_code', $fair_code) 
            : $exhibitor->attendances->firstWhere('fair_code', $exhibitor->fair_code);

        $exhibitor->status = $attendance->status ?? 0;
        $exhibitor->conforme_review = $attendance->conforme_review ?? 0;
        $exhibitor->registration_agreed_at = $attendance->registration_agreed_at ?? null;

        // ✅ NEW FIELDS
        $participationType = $attendance->participation_type ?? null;
        $sponsorshipResponse = $attendance->sponsorship_response ?? null;

        $exhibitor->participation_type_label =
            $participationType === 1 ? 'Individual' :
            ($participationType === 2 ? 'Group' : null);

        $exhibitor->sponsorship_response_label =
            $sponsorshipResponse === 1 ? 'Yes' :
            ($sponsorshipResponse === 0 ? 'No' : null);


        $exhibitor->user_name = $exhibitor->user->name ?? null;
        $exhibitor->id = $exhibitor->uid;

        // --- Display status logic (unchanged) ---
        if ($exhibitor->status == 0) {
            $exhibitor->display_status = 'Incomplete';
        } elseif ($exhibitor->status == 2) {
            $exhibitor->display_status = 'Pending';
        } elseif ($exhibitor->status == 3) {
            $exhibitor->display_status = 'Reviewed';
        } elseif ($exhibitor->status == 4) {
            $exhibitor->display_status = 'Onhold';
        } elseif ($exhibitor->status == 5) {
            $exhibitor->display_status = 'Denied';
        } elseif ($exhibitor->status == 1 && !$exhibitor->conforme_review) {
            $exhibitor->display_status = 'Pending Conforme Generation';
        } elseif ($exhibitor->status == 1 && $exhibitor->conforme_review == 1) {
            $exhibitor->display_status = 'Approved';
        } else {
            $exhibitor->display_status = 'Unknown';
        }

        return $exhibitor;
    });



    $arr_permissions = [
        'can_view' => Auth::user()->can('view reg_suppliers'),
        'can_resend' => Auth::user()->can('resend reg_suppliers'),
        'can_approved' => Auth::user()->can('approve reg_suppliers'),
        'can_review' => Auth::user()->can('review reg_suppliers'),
        'can_hold' => Auth::user()->can('onhold reg_suppliers'),
        'can_deny' => Auth::user()->can('disapprove reg_suppliers'),
        'can_edit' => Auth::user()->can('edit reg_suppliers'),
        'can_add' => Auth::user()->can('add reg_suppliers'),
    ];

    return response()->json([
        'total' => $total_exhibitors,
        'data' => $records,
        'permissions' => $arr_permissions
    ], 200);
}



public function supplier_list(Request $request)
{
    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $filters = $request->has('filter') ? json_decode($request->input('filter'), true) : [];

    // --- Determine fair_code ---
    $fair_code = $filters['fair_code'] ?? null;
    if (!$fair_code) {
        $latestEvent = Event::latest()->first();
        $fair_code = $latestEvent ? $latestEvent->fair_code : null;
        $filters['fair_code'] = $fair_code;
    }

    // --- Base query ---
    $exhibitors = Exhibitor::with([
        'user',
        'reviewer',
        'approver',
        'disapprover',
        'onholder',
        'attendances' => fn($q) => $fair_code ? $q->where('fair_code', $fair_code) : null,
        'conformes' => fn($q) => $fair_code ? $q->where('fair_code', $fair_code)->latest() : null,
    ])->whereHas('user', fn($q) => $q->where('user_group', 5));

    // --- Filters ---
    if (!empty($filters)) {
        if (!empty($filters['co_name'])) {
            $exhibitors->where('co_name', 'like', '%' . $filters['co_name'] . '%');
        }
        if (!empty($filters['co_email'])) {
            $exhibitors->where('co_email', $filters['co_email']);
        }
        if (!empty($filters['fair_code'])) {
            $exhibitors->where('fair_code', $filters['fair_code']);
        }
    if (isset($filters['status']) && $filters['status'] !== '') {
        $statusFilter = (int) $filters['status'];

        // First, fetch exhibitors without overly complex RTB/Awaiting filters
        if (in_array($statusFilter, [0, 1, 2, 3, 4, 5])) {
            $exhibitors->where(function ($q) use ($statusFilter, $fair_code) {
                switch ($statusFilter) {
                    case 0: // Incomplete
                        $q->whereDoesntHave('attendances', fn($qq) =>
                            $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                            ->where('status', '>', 0)
                        );
                        break;

                    case 1: // Pending Conforme Generation (awaiting generation)
                        $q->whereHas('attendances', fn($qq) =>
                            $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                            ->where('status', ExhibitorAttendance::STATUS_PENDING_CONFORME_GENERATION)
                            ->where(function($q2) {
                                $q2->where('conforme_review', 0)
                                    ->orWhereNull('conforme_review');
                            })
                        );
                        break;

                    default: // 2,3,4,5
                        $q->whereHas('attendances', fn($qq) =>
                            $qq->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
                            ->where('status', $statusFilter)
                        );
                }
            });
        }

        
    
    }
    }

    if ($request->has('sort')) {
    $sort = json_decode($request->input('sort'), true);

    if (in_array($sort['field'], ['co_name', 'co_email', 'fair_code', 'created_at'])) {
        $exhibitors->orderBy($sort['field'], $sort['type']);
    }
    
}


    $total_exhibitors = $exhibitors->count();

    // --- Fetch records ---
$records = $exhibitors->offset($offset)
    ->limit($per_page)
    ->get()
    ->map(function ($exhibitor) {
        $attendance = $exhibitor->attendances->first();
        $conforme = $exhibitor->conformes->first();

        $status = $attendance->status ?? ExhibitorAttendance::STATUS_INCOMPLETE;

        $exhibitor->status = $status;
        $exhibitor->created_at = $attendance->created_at ?? null; 
        $exhibitor->registration_agreed_at = $attendance->registration_agreed_at ?? null;
        $exhibitor->user_name = $exhibitor->user->name ?? null;
        $exhibitor->id = $exhibitor->uid;

        $exhibitor->display_status = ExhibitorAttendance::resolveDisplayStatus($attendance);
        $exhibitor->soa_status = ExhibitorAttendance::resolveSOALabel($attendance);
        $exhibitor->payment_status = ExhibitorAttendance::resolvePaymentLabel($attendance);
        $exhibitor->is_soa_generated = $attendance->is_soa_generated ?? false;

    
        switch ($exhibitor->display_status) {
            case ExhibitorAttendance::LABEL_READY_FOR_RTB:
                $exhibitor->sort_order = 1; break;
            case ExhibitorAttendance::LABEL_AWAITING_CONFORME:
                $exhibitor->sort_order = 2; break;
            case ExhibitorAttendance::LABEL_PENDING_CONFORME_GENERATION:
                $exhibitor->sort_order = 3; break;
            case ExhibitorAttendance::LABEL_INCOMPLETE:
                $exhibitor->sort_order = 4; break;
            case ExhibitorAttendance::LABEL_PENDING:
                $exhibitor->sort_order = 5; break;
            case ExhibitorAttendance::LABEL_REVIEWED:
                $exhibitor->sort_order = 6; break;
            case ExhibitorAttendance::LABEL_ONHOLD:
                $exhibitor->sort_order = 7; break;
            case ExhibitorAttendance::LABEL_DENIED:
                $exhibitor->sort_order = 8; break;
            case 'New Status 6':
                $exhibitor->sort_order = 9; break;
            case 'New Status 7':
                $exhibitor->sort_order = 10; break;
            default:
                $exhibitor->sort_order = 99;
        }

        return $exhibitor;
    });


if (Auth::user()->user_group == 6) {
    $records = $records->filter(function ($ex) {
        return $ex->display_status === 'Generated RTB';
    })->values();
}


if (isset($filters['status']) && in_array($filters['status'], [6, 7])) {
    $statusFilter = (int) $filters['status'];

    $records = $records->filter(function ($ex) use ($statusFilter) {
        switch ($statusFilter) {
            case 6: // For RTB
                return $ex->display_status === ExhibitorAttendance::LABEL_READY_FOR_RTB;
            case 7: // Awaiting Conforme
                return $ex->display_status === ExhibitorAttendance::LABEL_AWAITING_CONFORME;
            case 8:
                return $ex->display_status === ExhibitorAttendance::LABEL_GENERATED_RTB;
        }
    })->values();
}

if (isset($filters['soa_status']) && $filters['soa_status'] !== '') {
    $soaFilter = (int) $filters['soa_status'];

    $exhibitors->whereHas('attendances', function ($q) use ($soaFilter, $fair_code) {
        $q->when($fair_code, fn($q2) => $q2->where('fair_code', $fair_code))
          ->where('is_soa_generated', $soaFilter);
    });
}

  
    if ($request->has('sort')) {
        $sort = json_decode($request->input('sort'), true);
        if ($sort['field'] === 'display_status') {
            $records = $records->sortBy(fn($ex) => $ex->sort_order, SORT_REGULAR, $sort['type'] === 'desc')->values();
        } elseif (!in_array($sort['field'], ['co_name', 'co_email', 'fair_code'])) {
            $records = $records->sortBy($sort['field'], SORT_REGULAR, $sort['type'] === 'desc')->values();
        }
    }


    $arr_permissions = [
        'can_view' => Auth::user()->can('view reg_suppliers'),
        'can_resend' => Auth::user()->can('resend reg_suppliers'),
        'can_approved' => Auth::user()->can('approve reg_suppliers'),
        'can_review' => Auth::user()->can('review reg_suppliers'),
        'can_hold' => Auth::user()->can('onhold reg_suppliers'),
        'can_deny' => Auth::user()->can('disapprove reg_suppliers'),
        'can_edit' => Auth::user()->can('edit reg_suppliers'),
        'can_add' => Auth::user()->can('add reg_suppliers'),
        'can_conforme' => Auth::user()->can('conforme reg_suppliers'),
        'can_soa' => Auth::user()->can('soa reg_suppliers'),
    ];

    return response()->json([
        'total' => $total_exhibitors,
        'data' => $records,
        'permissions' => $arr_permissions
    ], 200);
}

public function buyers_list(Request $request)
{
    $per_page = $request->input('per_page', 10);
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $filters = $request->has('filter') ? json_decode($request->input('filter'), true) : [];

 
    $fair_code = $filters['fair_code'] ?? null;
    if (!$fair_code) {
        // Get latest event's fair_code
        $latestEvent = Event::latest()->first();
        $fair_code = $latestEvent ? $latestEvent->fair_code : null;
        $filters['fair_code'] = $fair_code; 
    }

  
    $buyers = Buyer::with([
        'user',
        'b_country',
        'reviewer',
        'approver',
        'disapprover',
        'onholder',
        'buyer_attendances',
    ])->whereHas('user', function ($q) {
        $q->where('user_group', 3);
    });

    // --- Filters ---
// --- Filters ---
if (!empty($filters)) {

    // Company Name
    if (!empty($filters['co_name'])) {
        $buyers->where(
            'co_name',
            'like',
            '%' . $filters['co_name'] . '%'
        );
    }

    // Company Email
    if (!empty($filters['co_email'])) {
        $buyers->where(
            'co_email',
            $filters['co_email']
        );
    }

    // Fair Code
    if (!empty($filters['fair_code'])) {
        $buyers->where(
            'fair_code',
            $filters['fair_code']
        );
    }

    // Status
    if (isset($filters['status']) && $filters['status'] !== '') {

        $status = $filters['status'];

        if ($status === 'incomplete') {

            // Incomplete:
            // No attendance record for this fair with status > 0
            $buyers->whereDoesntHave('buyer_attendances', function ($q) use ($fair_code) {

                if ($fair_code) {
                    $q->where('fair_code', $fair_code);
                }

                $q->where('status', '>', 0);
            });

        } else {

            // Approved = 1
            // Pending  = 2
            // Reviewed = 3
            // On hold  = 4
            // Denied   = 5
            $buyers->whereHas('buyer_attendances', function ($q) use ($status, $fair_code) {

                if ($fair_code) {
                    $q->where('fair_code', $fair_code);
                }

                $q->where('status', $status);
            });
        }
    }
}
   
    if ($request->has('sort')) {
        $sort = json_decode($request->input('sort'), true);
        if (!in_array($sort['field'], ['co_name', 'co_email', 'fair_code'])) {
            $buyers->orderBy($sort['field'], $sort['type']);
        }
    }

    $total_buyers = $buyers->count();

  
    $records = $buyers->offset($offset)
        ->limit($per_page)
        ->get()
        ->map(function ($buyer) use ($fair_code) {
            $attendance = $fair_code
                ? $buyer->buyer_attendances->firstWhere('fair_code', $fair_code)
                : $buyer->buyer_attendances->firstWhere('fair_code', $buyer->fair_code);

            $buyer->status = $attendance->status ?? 0;
            $buyer->registration_agreed_at = $attendance->registration_agreed_at ?? null;
            $buyer->user_name = $buyer->user->name ?? null;
            $buyer->id = $buyer->uid;

            return $buyer;
        });

    $arr_permissions = [
        'can_view' => Auth::user()->can('view reg_buyers'),
        'can_resend' => Auth::user()->can('resend reg_buyers'),
        'can_approved' => Auth::user()->can('approve reg_buyers'),
        'can_review' => Auth::user()->can('review reg_buyers'),
        'can_hold' => Auth::user()->can('onhold reg_buyers'),
        'can_deny' => Auth::user()->can('disapprove reg_buyers'),
        'can_add' => Auth::user()->can('add reg_purchaser'),
        'can_edit' => Auth::user()->can('edit reg_purchaser'),
    ];

    return response()->json([
        'total' => $total_buyers,
        'data' => $records,
        'permissions' => $arr_permissions,
        'default_fair_code' => $fair_code, // optional: send to frontend
    ], 200);
}

public function supplier_create()
{
    return view('admin.registration.supplier.create');
}

public function supplier_info($id, $fair_code)
{
try {
    Log::info('user_information() called', ['id' => $id]);

    // Fetch user
    $user = User::find($id);
    if (! $user) {
        Log::error('User not found', ['id' => $id]);
        abort(404, 'User not found');
    }

    // Get latest ExhibitorAttendance
    //  $attendance = ExhibitorAttendance::where('user_id', $user->id)
    // ->where('fair_code', $fair_code)
    // ->first();

    
    $attendance = $user->exhibitorAttendanceForFair($fair_code);

    $pitching_competition_selection = $user
            ->pitchingSelectionsForFair($fair_code)
            ->with('pitchingSessionCategories')
            ->get();


if (! $attendance) {
    Log::warning('No ExhibitorAttendance record found for user with fair_code', [
        'user_id' => $user->id,
        'fair_code' => $fair_code
    ]);
    abort(404, 'No event attendance record found for this user and fair code.');
}

 $latestConforme = $attendance->latestConforme;
 $latestRtb = $attendance->latestRtb;

 // Log for debugging
if ($latestConforme) {
    Log::info('Latest Conforme found', [
        'id' => $latestConforme->id,
        'response' => $latestConforme->response,
        'email_token' => $latestConforme->email_token,
        'created_at' => $latestConforme->created_at,
    ]);
} else {
    Log::warning('No Latest Conforme found for this attendance', [
        'attendance_id' => $attendance->id
    ]);
}

    if ($user->user_group === 5) {
        // Supplier/Exhibitor
        $exhibitor = $user->exhibitorForFair($fair_code);
        if (! $exhibitor) {
            Log::warning('No exhibitor found for this fair', ['user_id' => $user->id, 'fair_code' => $fair_code]);
            abort(404, 'Exhibitor not found for this fair code');
        }

            $exhibitor->load([
            'reviewer',
            'approver',
            'disapprover',
            'onholder',
            'updater',
            ]);

        $user->setRelation('exhibitor', $exhibitor);
        $user->load([
            'products' => function ($q) use ($fair_code){
                $q->where('fair_code', $fair_code);
            },
            'business_owner' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'business_contact_person' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'certification' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'category_subcategory'=> function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'on_input_output' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'on_production_process' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'topic_rank',
            'nature_business' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'topic_pick'=> function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            }, 
            'document' => function($q) use ($fair_code) {
            $q->where('fair_code', $fair_code);
            },
            'target_buyer' => function ($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            }, 
        ]);


        $user['attendance_info'] = [
            'participation_type' => $attendance->participation_type ?? null,
            'conference_response' => $attendance->conference_response ?? null,
            'sponsorship_response' => $attendance->sponsorship_response ?? null,
            'status' => $attendance->status ?? null,
            'is_rtb_generated' => $attendance->is_rtb_generated ?? null,
            'conforme_review' => $attendance->conforme_review ?? null,
            'conforme_response' => $latestConforme->response ?? null,
            'conforme_file' => $latestConforme->noa_file ?? null,
            'rtb_file' => $latestRtb->rtb_file ?? null,
            ];

        $user['order_info'] = [
            'pitching_competition_selection' => $pitching_competition_selection->pluck('pitching_session_category_id')->toArray(),
            ];
        
            // Categories 
            if ($user->category_subcategory) {
                $catsub = [];
                foreach ($user->category_subcategory as $key => $category) {
                    $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
                }
                $user['catsub'] = $catsub;
            }

              if ($user->sdg) {
                $user['sdg'] = $user->sdg->map(function ($sdg) {
                    return [
                        'id' => $sdg->id,
                        'name' => $sdg->product_char_sdg->name,
                    ];
                });
            }

            // Input/Output
            if ($user->on_input_output) {
                $user['inout'] = $user->on_input_output->map(function ($inout) {
                    return [
                        'id' => $inout->id,
                        'name' => $inout->product_char_inputoutput->name,
                    ];
                });
            }

            // Production process
            if ($user->on_production_process) {
                $user['process'] = $user->on_production_process->map(function ($proc) {
                    return [
                        'id' => $proc->id,
                        'name' => $proc->product_char_prod_process->name,
                    ];
                });
            }

            // Nature of business
            if ($user->nature_business) {
                $user['nature_business'] = $user->nature_business->map(function ($nb) {
                    return [
                        'id' => $nb->id,
                        'name' => $nb->name,
                    ];
                })->toArray();
            }

            // Target buyer
            if ($user->target_buyer) {
                $user['target_buyer'] = $user->target_buyer->map(function ($tb) {
                    return [
                        'id' => $tb->id,
                        'name' => $tb->buyer ? $tb->buyer->name : null,
                    ];
                })->toArray();
            }

            // Topic picks
            if ($user->topic_pick) {
                $user['topic_picks'] = $user->topic_pick->map(function ($pick) {
                    return [
                        'id' => $pick->topic_id,
                        'name' => $pick->focus_topic ? $pick->focus_topic->name : null,
                    ];
                });
            }

            // Masthead and Logo
            if ($user->masthead) {
                $user['masthead'] = pathinfo('/storage/exhibitors/mastheads/' . $user->masthead);
            }
            if ($user->logo) {
                $user['logo'] = pathinfo('/storage/exhibitors/logos/' . $user->logo);
            }

            // Documents
            $docs = [
                'dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate',
                'institutional_catalog', 'business_certification','food_or_environmental_certification'
            ];
            foreach ($docs as $key => $docField) {
                if (!empty($user->document->{$docField})) {
                    $user['doc'.($key+1)] = pathinfo($user->document->{$docField});
                    $user['doc'.($key+1).'_url'] = Storage::url($user->document->{$docField});
                    $user['doc'.($key+1).'_filesize'] = Storage::size($user->document->{$docField});
                }
            }

    } else {
        // Buyer
        Log::info('Loading buyer relations for user', ['id' => $user->id]);
        $user->load([
            'buyer',
            'category_subcategory',
            'nature_business',
            'participation_goal',
            'learn_about_event',
        ]);

        if ($user->category_subcategory) {
            $catsub = [];
            foreach ($user->category_subcategory as $key => $category) {
                $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
            }
            $user['catsub'] = $catsub;
        }
    }
$user['attendance'] = $attendance->toArray();

$arr_permissions = [
    'can_view'              => Auth::user()->can('view reg_suppliers'),
    'can_resend_conforme'   => Auth::user()->can('resend conforme_suppliers'),
    'can_edit'              => Auth::user()->can('edit reg_suppliers'),
    'can_approved' => Auth::user()->can('approve reg_suppliers'),
    'can_review'   => Auth::user()->can('review reg_suppliers'),
    'can_hold'     => Auth::user()->can('onhold reg_suppliers'),
    'can_deny'     => Auth::user()->can('disapprove reg_suppliers'),
    'can_pending'     => Auth::user()->can('pending reg_suppliers'),
    'can_revert'     => Auth::user()->can('revert reg_suppliers'),
    'conforme'     => Auth::user()->can('conforme reg_suppliers'),
];

$user['permissions'] = $arr_permissions;
        // Final log
        try {
            Log::info('Final user data:', ['user' => $user->toArray()]);
        } catch (\Throwable $e) {
            Log::error('Failed to serialize user for logging', ['error' => $e->getMessage()]);
        }

        return response()->json($user, 200);

    } catch (\Throwable $e) {
        Log::error('Error in user_information()', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Something went wrong'], 200);
    }
}

public function buyer_information($id, $fair_code){


    $user = User::findOrFail($id);

    $user['buyerclass'] = (int) $user->buyerclass;
    
    $buyer = $user->buyer()->where('fair_code',  $fair_code)->first();

    if ($buyer) {
        $user['buyer'] = $buyer;
        $user['created_at'] = $buyer->created_at;
        $user['updated_at'] = $buyer->updated_at;
        // Access related attributes safely
        $buyer->b_country;
        $buyer->job_function;
        $buyer->organization_type;
        $user['nature_business'] = $user->nature_business()
                                ->where('fair_code', $fair_code)
                                ->get();
        $user['category_subcategory'] = $user->category_subcategory()
                                    ->where('fair_code', $fair_code)
                                    ->get();

        $user['participation_goal'] = $user->participation_goal()
                                    ->where('fair_code', $fair_code)
                                    ->get();
        $user['learn_about_event'] = $user->learn_about_event()
                                    ->where('fair_code', $fair_code)
                                    ->get();
        $buyer->reviewer;
        $buyer->approver;
        $buyer->disapprover;
        $buyer->onholder;
        $buyer->last_update;

        $arr_categories = [];
        if (!empty($user->category_subcategory)) {
            foreach ($user->category_subcategory as $key => $category) {
                $arr_categories[$category->category_remarks][$key] = $category->sub_category_remarks;
            }
            $user['catsub'] = $arr_categories;
        }
            $attendance = $user->buyerAttendances()->where('fair_code', $fair_code)->first();
    $user['status'] = $attendance->status ?? null;
    } else {
        // No buyer exists for this event yet
        $user['buyer'] = null;
            $user['status'] = null;
        $user['created_at'] = null;
        $user['updated_at'] = null;
    }
$arr_permissions = [
    'can_view'     => Auth::user()->can('view reg_buyers'),
    'can_resend'   => Auth::user()->can('resend reg_buyers'),
    'can_approved' => Auth::user()->can('approve reg_buyers'),
    'can_review'   => Auth::user()->can('review reg_buyers'),
    'can_hold'     => Auth::user()->can('onhold reg_buyers'),
    'can_deny'     => Auth::user()->can('disapprove reg_buyers'),
    'can_pending'     => Auth::user()->can('pending reg_buyers'),
    'can_revert'     => Auth::user()->can('revert reg_buyers'),
];

$user['permissions'] = $arr_permissions;

    return response()->json($user, 200);

}

public function view($id, $fair_code)
    {
        return view('admin.registration.supplier.view', ['id' => $id,'fair_code' => $fair_code]);
}

public function buyer_view($id, $fair_code)
{
    $user = User::where('id', $id)
            ->where('user_group', 3) 
            ->first();

if (!$user || !$user->buyer()->where('fair_code', $fair_code)->exists()) {
    return redirect()->route('admin.buyers.registration')
                        ->with('error', 'Buyer or event not found');
}

    return view('admin.registration.buyer.view', ['id' => $id,'fair_code' => $fair_code]);
}

public function resend_registation_link($id)
{
    $user = User::findOrFail($id);
    if ($user->user_group === 2) {
        //SUPPLIER
        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($user->email))->send(new ExhibitorEmailRegistrationValidation($user->id));
        } else {
            Mail::to('kgtecson.citem@gmail.com')->send(new ExhibitorEmailRegistrationValidation($user->id));
        }
    } else {
        //BUYER
        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($request->input('ref_email')))->send(new BuyerEmailRegistrationValidation($user->id));
        } else {
            Mail::to('kgtecson.citem@gmail.com')->send(new BuyerEmailRegistrationValidation($user->id));
        }
    }
    return response()->json(true, 200);
}

public function review(Request $request, $id)
{
    $user = User::findOrFail($id);
    $fair_code = $request->fair_code;

    if ($user->user_group === 5) {
      
        $exhibitor = $user->exhibitorForFair($fair_code);
  // ✅ Update Exhibitor Attendance status
        $attendance = $user->exhibitorAttendanceForFair($fair_code);


        if ($exhibitor) {
            $exhibitor->update([
                'reviewed_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        }

        if ($attendance) {
            $attendance->update([
                'status'     => 3, // reviewed
            ]);
        }

        $attendance->timestamps = false;
        $attendance->participation_type = $request->participation_type ?? null;
        $attendance->save();
        $attendance->timestamps = true;

        $this->touchExhibitor($user, $fair_code);
    
    } else {
         $buyer = $user->buyerForFair($fair_code);

        if ($buyer) {
            $buyer->update([
                'reviewed_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        } 

        $attendance = $user->buyerAttendanceForFair($fair_code);

        if ($attendance) {
            $attendance->update([
                'status'     => 3, // reviewed
            ]);
        }

        $this->touchBuyer($user, $fair_code);
    }

    // ✅ Keep API sync
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIValidateStatus($user->email, 'reviewed', $user->user_group);
    // }

    return response()->json(true, 200);
}

public function pending(Request $request, $id)
{
    $user = User::findOrFail($id);
    $fair_code = $request->fair_code;

    if ($user->user_group === 5) {
      
        $exhibitor = $user->exhibitorForFair($fair_code);

        if ($exhibitor) {
            $exhibitor->update([
                'reviewed_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        }

        // ✅ Update Exhibitor Attendance status
        $attendance = $user->exhibitorAttendanceForFair($fair_code);

        if ($attendance) {
            $attendance->update([
                'status'     => 2, // reviewed
            ]);
        }
$this->touchExhibitor($user, $fair_code);
    } else {
        $buyer = $user->buyerForFair($fair_code);

        if ($buyer) {
            $buyer->update([
                'reviewed_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        }

        //  Buyer Attendance status
        $attendance = $user->buyerAttendanceForFair($fair_code);

        if ($attendance) {
            $attendance->update([
                'status'     => 2, // reviewed
            ]);
        }
        $this->touchBuyer($user, $fair_code);
    }

   
    return response()->json(true, 200);
}

public function revert_to_inc(Request $request, $id)
{
$user = User::findOrFail($id);
$fair_code = $request->fair_code;

if ($user->user_group === 5) {
    // --------------------------
    // EXHIBITOR logic (unchanged)
    // --------------------------
    $exhibitor = $user->exhibitorForFair($fair_code);
    if ($exhibitor) {
        $exhibitor->update([
            'reviewed_by' => Auth::id(),
            'updated_by'  => Auth::id(),
        ]);
    }

    $attendance = $user->exhibitorAttendanceForFair($fair_code);
    if ($attendance) {
        $attendance->update([
            'status' => 0, // reviewed
        ]);
    }

    $this->touchExhibitor($user, $fair_code);

} else {
    // --------------------------
    // BUYER logic
    // --------------------------
    $buyer = $user->buyerForFair($fair_code);
    if ($buyer) {
        $buyer->update([
            'reviewed_by'    => Auth::id(),
            'last_update_by' => Auth::id(),
        ]);
    }

    $attendance = $user->buyerAttendanceForFair($fair_code);
    if ($attendance) {
        $attendance->update([
            'status' => 0, // reverted to incomplete
        ]);
    }

    $this->touchBuyer($user, $fair_code);

    // --------------------------
    // Send “Returned to Incomplete” email to buyer
    // --------------------------
    $recipient = env('APP_ENV') !== 'local' ? $user->email : 'kgtecson.citem@gmail.com';
    Mail::to($recipient)->send(new RevertToIncomplete($user->id, $fair_code));
}

    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIValidateStatus($user->email, 'reviewed', $user->user_group);
    // }

// --------------------------
// Return JSON response
// --------------------------
return response()->json(true, 200);
}

public function supplier_update(Request $request)
{
    $user = User::where('id', $request->input('user_id'))->firstOrFail();

    $company_info = json_decode($request->input('company_info'), true);
    $contact_info = json_decode($request->input('contact_info'), true);
    $business_info = json_decode($request->input('business_info'), true);
    // HIDDEN 20230908 ORDER INFO
    // $order_info = json_decode($request->input('order_info'), true);

    $status = $request->input('status');
    if ($status) {
        $user->status = 2;
    }
    
    $destinationPath = storage_path('app/public/exhibitors/');

    if ($request->hasFile('company_masthead')) {
        $masthead = $request->file('company_masthead');
        if ($masthead) {
            $filename_masthead = md5(time()).'.'.$masthead->clientExtension();
            $resize_masthead = Image::make($masthead);
            $resize_masthead->fit(1920, 400, function ($constraint) {
                $constraint->upsize();
            });
            $resize_masthead->save($destinationPath.'/mastheads/'.$filename_masthead, 70);
            $resize_masthead->fit(290, 160, function ($constraint) {
                $constraint->upsize();
            });
            $resize_masthead->save($destinationPath.'/thumbs/'.$filename_masthead, 70);
            $user->masthead = $filename_masthead;
        }
    }
    if ($request->hasFile('company_logo')) {
        $logo = $request->file('company_logo');
        if ($logo) {
            $filename_logo = md5(time()).'.'.$logo->clientExtension();
            $logo_canvas = Image::canvas(156, 156);
            $resize_logo = Image::make($logo);
            $resize_logo->resize(155, 155, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $logo_canvas->insert($resize_logo, 'center');
            $logo_canvas->save($destinationPath.'/logos/'.$filename_logo, 70);
            $user->logo = $filename_logo;
        }
    }
    $user->save();

    

    $arr_country_exporting_to = [];
    if (!empty($business_info['country_exporting_to'])) {
        foreach ($business_info['country_exporting_to'] as $country_exporting_to_key => $country_exporting_to_value) {
            $arr_country_exporting_to['ir_country_exporting_'.($country_exporting_to_key+1)] = $country_exporting_to_value['id'];
        }
    }


    $arr_target_countries = [];
    if (!empty($business_info['target_countries_export'])) {
        foreach ($business_info['target_countries_export'] as $target_countries_export_key => $target_countries_export_value) {
            $arr_target_countries['target_country_export_'.($target_countries_export_key+1)] = $target_countries_export_value['id'];
        }
    }


    $arr_supplier_info = [
        'co_name' => Str::upper($company_info['co_name']),
        'slug' => Str::of($company_info['co_name'])->slug('-'),
        'directory_name' => Str::title($company_info['directory_name']),
        'co_details' => $company_info['co_profile'],
        'mission_statement' => $company_info['mission'],
        'env_conservation' => $company_info['env_conservation'],
        'phone_country_code' => $company_info['phone_country_code'],
        'phone_area_code' => $company_info['phone_area_code'],
        'phone_no' => $company_info['phone_no'],
        'mobile_country_code' => $company_info['mobile_country_code'],
        'mobile_no' => $company_info['mobile_no'],
        'website' => $company_info['website'],
        'facebook' => $company_info['facebook'],
        'twitter' => $company_info['twitter'],
        'instagram' => $company_info['instagram'],
        'linkedin' => $company_info['linkedin'],
        'other_social' => $company_info['other_social'],
        'fa_country' => $company_info['fa_country'],
        'fa_state' => $company_info['fa_state'],
        'fa_city' => $company_info['fa_city'],
        'fa_zipcode' => $company_info['fa_zipcode'],
        'fa_region' => $company_info['fa_region'],
        'fa_street' => $company_info['fa_street'],
        'moa_country' => $company_info['moa_country'],
        'moa_state' => $company_info['moa_state'],
        'moa_city' => $company_info['moa_city'],
        'moa_zipcode' => $company_info['moa_zipcode'],
        'moa_region' => $company_info['moa_region'],
        'moa_street' => $company_info['moa_street'],
        // PAST ERROR POINT
        'business_type_id' => $business_info['business_type'] ? $business_info['business_type'] : NULL,
        'company_size_id' => $business_info['company_size'] ? $business_info['company_size'] : NULL,
        'annual_sales_volume_id' => $business_info['annual_sales_volume'] ? $business_info['annual_sales_volume'] : NULL,
        'direct_workers' => $business_info['direct_workers'] ? $business_info['direct_workers'] : NULL,
        'indirect_workers' => $business_info['indirect_workers'] ? $business_info['indirect_workers'] : NULL,
        'organization_type_id' => $business_info['organization_type'] ? $business_info['organization_type'] : NULL,
        'industry_rep' => $business_info['industry_rep'] ? $business_info['industry_rep'] : NULL,
        'product_promoted' => $business_info['product_promoted'] ? $business_info['product_promoted'] : NULL,
        // END PAST ERROR POINT
        // HIDDEN 20230908 ORDER INFO
        // 'banner_size_id' => $order_info['banner_size'],
        'updated_by' => Auth::id()
    ];

    
    $arr_supplier_info_merge = array_merge($arr_supplier_info,  $arr_country_exporting_to, $arr_target_countries);
    //print_r($arr_supplier_info_merge); exit;
    $user->exhibitor()->update($arr_supplier_info_merge);

    

    $user->products()->update([
        'status' => 1
    ]);

    //NATURE BUSINESS
    if (!empty($user->nature_business)) {
        $user->nature_business()->delete();
    }
    $arr_nature_business = [];
    foreach ($business_info['nature_business'] as $nb) {
        $nature_business = NatureBusiness::find($nb);
        if (!empty($nature_business)) {
            $arr_nature_business[] = [
                'nature_business_id' => $nature_business->id,
                'remarks' => $nature_business->name
            ];
        }
    }
    $user->nature_business()->createMany($arr_nature_business);

    

    //TARGET BUYERS
    if (!empty($user->target_buyer)) {
        $user->target_buyer()->delete();
    }
    $arr_target_buyers = [];
    foreach ($business_info['target_buyers'] as $target) {
        $target_buyer = TargetBuyer::find($target);
        if (!empty($target_buyer)) {
            if ($target_buyer->id === 6) {
                $remarks = Str::title($business_info['target_buyer_others']);
            } else {
                $remarks = $target_buyer->name;
            }
            $arr_target_buyers[] = [
                'target_buyer_id' => $target_buyer->id,
                'remarks' => $remarks
            ];
        }
    }
    $user->target_buyer()->createMany($arr_target_buyers);

    

    //CERTIFICATIONS
    if (!empty($user->certification)) {
        $user->certification()->delete();
    }
    $arr_certifications = [];
    foreach ($business_info['certifications'] as $cert) {
        $certification = Certification::find($cert);
        if (!empty($certification)) {
            if ($certification->id === 14) {
                $remarks = Str::title($business_info['certification_others']);
            } else {
                $remarks = $certification->name;
            }
            $arr_certifications[] = [
                'certification_id' => $certification->id,
                'remarks' => $remarks
            ];
        }
    }
    $user->certification()->createMany($arr_certifications);

    


    //Categories & Sub-Categories
    if (!empty($user->category_subcategory)) {
        $user->category_subcategory()->delete();
    }
    $arr_categories = [];
    foreach ($business_info['categories'] as $sub) {
        $sub_category = SubCategory::find($sub);
        if (!empty($sub_category)) {
            $arr_categories[] = [
                'category_id' => $sub_category->category_id,
                'category_remarks' => $sub_category->category->name,
                'sub_category_id' => $sub_category->id,
                'sub_category_remarks' => $sub_category->name
            ];
        }
    }
    $user->category_subcategory()->createMany($arr_categories);

    //On Input / Output
    if (!empty($user->on_input_output)) {
        $user->on_input_output()->delete();
    }
    $arr_input_ouput = [];
    foreach ($business_info['on_input_output'] as $input_output) {
        $arr_input_ouput[] = [
            'input_output_id' => $input_output
        ];
    }
    $user->on_input_output()->createMany($arr_input_ouput);

    

    //On Production Process
    if (!empty($user->on_production_process)) {
        $user->on_production_process()->delete();
    }
    $arr_production_process = [];
    foreach ($business_info['production_process'] as $pprocess) {
        if ($pprocess === 3) {
            $pp_remarks = Str::title($business_info['production_process_others']);
        } else {
            $pp_remarks = NULL;
        }
        $arr_production_process[] = [
            'production_process_id' => $pprocess,
            'other_certification' => $pp_remarks
        ];
    }
    $user->on_production_process()->createMany($arr_production_process);


    //TOPIC RANGKING
    if (!empty($user->topic_rank)) {
        $user->topic_rank()->delete();
    }
    $arr_topic_rank = [];
    foreach ($business_info['topic_rank'] as $rank_key => $rank) {
        if ($rank_key >= 1) {
            $arr_topic_rank[] = [
                'topic_id' => $rank_key,
                'rank' => $rank
            ];
        }
    }
    $user->topic_rank()->createMany($arr_topic_rank);

    

    $user->business_owner()->updateOrCreate(
        [
            'uid' => $user->id
        ],
        [
            'fname' => Str::title($contact_info['business_owner']['fname']),
            'lname' => Str::title($contact_info['business_owner']['lname']),
            'mi' => Str::upper($contact_info['business_owner']['mi']),
            'designation' => $contact_info['business_owner']['designation'],
            'email' => str::lower($contact_info['business_owner']['email']),
            'country_code' => $contact_info['business_owner']['country_code'],
            'mobile_no' => $contact_info['business_owner']['mobile_no']
        ]
    );



    $user->business_contact_person()->updateOrCreate(
        [
            'uid' => $user->id
        ],
        [
            'fname' => Str::title($contact_info['business_contact_person']['fname']),
            'lname' => Str::title($contact_info['business_contact_person']['lname']),
            'mi' => Str::upper($contact_info['business_contact_person']['mi']),
            'designation' => $contact_info['business_contact_person']['designation'],
            'email' => str::lower($contact_info['business_contact_person']['email']),
            'country_code' => $contact_info['business_contact_person']['country_code'],
            'mobile_no' => $contact_info['business_contact_person']['mobile_no']
        ]
    );

    


    if ($request->hasFile('doc1')) {
        $doc1 = $request->file('doc1')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc1 = $user->document->dti_sec;
        } else {
            $doc1 = NULL;
        } 
    }
    if ($request->hasFile('doc2')) {
        $doc2 = $request->file('doc2')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc2 = $user->document->bir;
        } else {
            $doc2 = NULL;
        }
    }
    if ($request->hasFile('doc3')) {
        $doc3 = $request->file('doc3')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc3 = $user->document->lto;
        } else {
            $doc3 = NULL;
        }
    }
    if ($request->hasFile('doc4')) {
        $doc4 = $request->file('doc4')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc4 = $user->document->cpr;
        } else {
            $doc4 = NULL;
        }
    }
    if ($request->hasFile('doc5')) {
        $doc5 = $request->file('doc5')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc5 = $user->document->other_food_certificatecpr;
        } else {
            $doc5 = NULL;
        }
    }
    if ($request->hasFile('doc6')) {
        $doc6 = $request->file('doc6')->store('public/documents', 'local');
    } else {
        if (!empty($user->document)) {
            $doc6 = $user->document->institutional_catalog;
        } else {
            $doc6 = NULL;
        }
    }

    

    $user->document()->updateOrCreate(
        [
            'uid' => $user->id
        ],
        [
            'dti_sec' => $doc1,
            'bir' => $doc2,
            'lto' => $doc3,
            'cpr' => $doc4,
            'other_food_certificate' => $doc5,
            'institutional_catalog' => $doc6
        ]
    );

    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateExhibitor($user->id);
    //     if ($status) {
    //         $this->citemAPIValidateStatus($user->email, $status, $user->user_group);
    //     }
    // }
    // $this->generate_pdf($user->id);
    return response()->json(true, 200);

}

protected function touchExhibitor($user, $event_fair_code)
{
if (! $exhibitor = $user->exhibitor()->where('fair_code', $event_fair_code)->first()) {
    return;
}

$exhibitor->touch();
}

protected function touchBuyer($user, $event_fair_code)
{
if (! $buyer = $user->buyer()->where('fair_code', $event_fair_code)->first()) {
    return;
}

$buyer->touch();
}

public function supplier_store(Request $request){

    $user = User::findOrFail($request->input('user_id'));
    $authUserId = Auth::user();

    $event_fair_code = $request->input('event_fair_code');
    $attendance = $user->exhibitorAttendanceForFair($event_fair_code);
    $is_pending = $request->input('to_pending');

if ((int) $is_pending === 1) {
    ExhibitorAttendance::updateOrCreate(
        [
            'user_id'   => $user->id,
            'fair_code' => $event_fair_code,
        ],
        ['status' => 2]
    );
    $this->touchExhibitor($user, $event_fair_code);
    $attendance = $user->exhibitorAttendanceForFair($event_fair_code);
}

    $status =  $attendance->status;

if ($request->input('step') == 1) {
    // STEP 1: Logo, Masthead, Exhibitor info
    $step1_decode = json_decode($request->input('step1_data'), true);
    // Server-side validation to prevent overly long/payloads
    $validator = Validator::make($step1_decode, [
        'directory_name' => 'nullable|string|max:100',
        'exhibitor_type' => 'nullable|integer|in:1,2',
        'last_participated' => [
            'nullable',
            'integer',
            'min:1900',
            'max:' . date('Y'),
            'required_if:exhibitor_type,2',
        ],
        'fascia_name' => 'nullable|string|max:100',
        'co_details' => 'nullable|string|max:2000',
        'mission' => 'nullable|string|max:1000',
        'env_conservation' => 'nullable|string|max:1000',
        'country_code' => 'nullable',
        'area_code' => 'nullable|string|max:5',
        'phone_no' => 'nullable|string|max:12',
        'country_code_mobile' => 'required',
        'mobile_no' => 'nullable|string|max:12',
        'website' => 'nullable|string|max:195',
        'facebook' => 'nullable|string|max:195',
        'twitter' => 'nullable|string|max:195',
        'instagram' => 'nullable|string|max:195',
        'linkedin' => 'nullable|string|max:195',
        'other_social' => 'nullable|string|max:195',
        'moa_country' => 'nullable',
        'moa_state' => 'nullable|string|max:95',
        'moa_city' => 'nullable|string|max:95',
        'moa_zipcode' => 'nullable|string|max:15',
        'moa_region' => 'nullable|string|max:95',
        'moa_street' => 'nullable|string|max:195',
        'fa_country' => 'nullable',
        'fa_state' => 'nullable|max:95',
        'fa_city' => 'nullable|max:95',
        'fa_zipcode' =>'nullable|max:15',
        'fa_region' => 'nullable|max:95',
        'fa_street' => 'nullable|max:195',
      
    ], [
        'required' => ':attribute is required.',
        'string'   => ':attribute must be a valid text.',
        'max'      => ':attribute must not exceed :max characters.',
    ],
    [
        'directory_name' => 'Directory name',
        'co_details' => 'Company details',
        'mission' => 'Mission',
        'env_conservation' => 'Environmental conservation',
        'country_code' => 'Country code (Phone)',
        'area_code' => 'Area code',
        'phone_no' => 'Phone number',
        'country_code_mobile' => 'Country code (Mobile)',
        'mobile_no' => 'Mobile number',
        'website' => 'Website',
        'facebook' => 'Facebook URL',
        'twitter' => 'Twitter URL',
        'instagram' => 'Instagram URL',
        'linkedin' => 'LinkedIn URL',
        'other_social' => 'Other Social Media',
        'moa_country' => 'Main Office Address Country',
        'moa_state' => 'Main Office Address State',
        'moa_city' => 'Main Office Address City',
        'moa_zipcode' => 'Main Office Address Zipcode',
        'moa_region' => 'Main Office Address Region',
        'moa_street' => 'Main Office Address Street',
        'fa_country' => 'Factory Address Country',
        'fa_state' => 'Factory Address State',
        'fa_city' => 'Factory Address City',
        'fa_zipcode' => 'Factory Address Zipcode',
        'fa_region' => 'Factory Address Region',
        'fa_street' => 'Factory Address Street',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }
    $destinationPath = storage_path('app/public/exhibitors/');

    // Logo
    if ($request->hasFile('logo')) {
        $logo = $request->file('logo');
        $filename_logo = md5(time()).'.'.$logo->clientExtension();
        $logo_canvas = Image::canvas(156, 156);
        $resize_logo = Image::make($logo);
        $resize_logo->resize(155, 155, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $logo_canvas->insert($resize_logo, 'center');
        $logo_canvas->save($destinationPath.'/logos/'.$filename_logo, 70);
        $user->logo = $filename_logo;
    }

    // Masthead
    if ($request->hasFile('masthead')) {
        $masthead = $request->file('masthead');
        $filename_masthead = md5(time()).'.'.$masthead->clientExtension();
        $resize_masthead = Image::make($masthead);
        $resize_masthead->fit(1920, 400, function ($constraint) {
            $constraint->upsize();
        });
        $resize_masthead->save($destinationPath.'/mastheads/'.$filename_masthead, 70);
        $resize_masthead->fit(290, 160, function ($constraint) {
            $constraint->upsize();
        });
        $resize_masthead->save($destinationPath.'/thumbs/'.$filename_masthead, 70);
        $user->masthead = $filename_masthead;
    }

    $user->save();

        // Only fetch the exhibitor for this fair_code
    $exhibitor = $user->exhibitorForFair($event_fair_code);
    if (! $exhibitor) {
        // Create a new exhibitor if it doesn't exist for this fair
        $exhibitor = $user->exhibitor()->create(['fair_code' => $event_fair_code]);
    }


// Uepdate exhibitor details
    $exhibitor->update([
        'exhibitor_type' => $step1_decode['exhibitor_type'],
        'last_participated_year' => $step1_decode['last_participated'] ?? null,
         'fascia_name' => Str::title($step1_decode['fascia_name']),
        'directory_name' => Str::title($step1_decode['directory_name']),
        'co_details' => $step1_decode['co_details'],
        'mission_statement' => $step1_decode['mission'],
        'env_conservation' => $step1_decode['env_conservation'],
        'phone_country_code' => $step1_decode['country_code'],
        'phone_area_code' => $step1_decode['area_code'],
        'phone_no' => $step1_decode['phone_no'],
        'mobile_country_code' => $step1_decode['country_code_mobile'],
        'mobile_no' => $step1_decode['mobile_no'],
        'website' => $step1_decode['website'],
        'facebook' => $step1_decode['facebook'],
        'twitter' => $step1_decode['twitter'],
        'instagram' => $step1_decode['instagram'],
        'linkedin' => $step1_decode['linkedin'],
        'other_social' => $step1_decode['other_social'],
        'fa_country' => $step1_decode['fa_country'],
        'fa_state' => $step1_decode['fa_state'],
        'fa_city' => $step1_decode['fa_city'],
        'fa_zipcode' => $step1_decode['fa_zipcode'],
        'fa_region' => $step1_decode['fa_region'],
        'fa_street' => $step1_decode['fa_street'],
        'fa_same_as_moa' => $step1_decode['same_as_moa'],
        'moa_country' => $step1_decode['moa_country'],
        'moa_state' => $step1_decode['moa_state'],
        'moa_city' => $step1_decode['moa_city'],
        'moa_zipcode' => $step1_decode['moa_zipcode'],
        'moa_region' => $step1_decode['moa_region'],
        'moa_street' => $step1_decode['moa_street'], 
        'updated_by' => $authUserId->id,
       
    ]);


    } elseif ($request->input('step') == 'add_product') {
        $prod_info = json_decode($request->input('prod_info'), true);

        // Validate product inputs
        $prodValidator = Validator::make($prod_info, [
            'prod_name' => 'required|string|max:95',
            'prod_details' => 'nullable|string|max:410',
            'store_url' => 'nullable|url|max:200',
        ],  [
        'required' => ':attribute is required.',
        'string'   => ':attribute must be valid text.',
        'max'      => ':attribute must not exceed :max characters.',
        'url'      => ':attribute must be a valid URL.',
    ],
    // ✅ Custom readable attribute names
    [
        'prod_name' => 'Product name',
        'prod_details' => 'Product details',
        'store_url' => 'Store URL',
    ]);
        if ($prodValidator->fails()) {
            return response()->json(['errors' => $prodValidator->errors()], 422);
        }

        $product = $user->products()->updateOrCreate(
    [
        'id' => $request->input('product_id'),
        'fair_code' => $event_fair_code, // Ensure product matches this fair
    ],
    [
        'name' => $prod_info['prod_name'],
        'fair_code' => $event_fair_code,
        'slug' => Str::of($prod_info['prod_name'])->slug('-'),
        'description' => $prod_info['prod_details'],
        'store_url' => $prod_info['store_url'],
        'status' => 2,
    ]
);
        $destinationPath = storage_path('app/public/exhibitors/products');
        $arr_product_images = [];
        
    if (!empty($prod_info['prod_images_for_upload'])) {
        foreach ($prod_info['prod_images_for_upload'] as $key => $photo) {
            $filename = md5(time()).'_'.uniqid().'.'.$photo['ext'];
            $productImage = Image::make($photo['urlResized']);
            $size = $productImage->filesize();

            $productImage->fit(360, 200, function ($constraint1) {
                $constraint1->upsize();
            });
            $productImage->save($destinationPath.'/thumbs/'.$filename);

            $productImage->fit(800, 620, function ($constraint2) {
                $constraint2->upsize();
            });
            
            $productImage->save($destinationPath.'/'.$filename);

            $arr_product_images[] = [
                'image' => $filename,
                'img_size' => $size,
                'img_type' => 'image/'.$photo['ext'],
                'img_ext' => $photo['ext']
            ];
        }
        $product->product_images()->createMany($arr_product_images);
    }

    //Categories & Sub-Categories
    if (!empty($product->product_profiles)) {
        $product->product_profiles()->delete();
    }
    $arr_categories = [];
    foreach ($prod_info['prod_profiles'] as $sub) {
        $sub_category = SubCategory::find($sub);
        if (!empty($sub_category)) {
            $arr_categories[] = [
                'category_id' => $sub_category->category_id,
                'category_remarks' => $sub_category->category->name,
                'sub_category_id' => $sub_category->id,
                'sub_category_remarks' => $sub_category->name
            ];
        }
    }

    $product->product_profiles()->createMany($arr_categories);

    //CERTIFICATIONS
    if (!empty($product->product_certifications)) {
        $product->product_certifications()->delete();
    }
    $arr_certifications = [];
    foreach ($prod_info['prod_certs'] as $cert) {
        $certification = Certification::find($cert);
        if (!empty($certification)) {
            if ($certification->id === 14) {
                $remarks = Str::title($prod_info['certs_others']);
            } else {
                $remarks = $certification->name;
            }
            $arr_certifications[] = [
                'certification_id' => $certification->id,
                'remarks' => $remarks
            ];
        }
    }

    $product->product_certifications()->createMany($arr_certifications);
    
$this->touchExhibitor($user, $event_fair_code);


    
    } elseif ($request->input('step') == 'save_product') {
        $user->products()->update([
            'status' => 2
        ]);
    $this->touchExhibitor($user, $event_fair_code);
    } elseif ($request->input('step') == 2) {
        $step2_decode = json_decode($request->input('step2_data'), true);
        $validator2 = Validator::make($step2_decode, [
            'salutation' => 'nullable|string|max:10',
            'fname' => 'nullable|string|max:95',
            'lname' => 'nullable|string|max:95',
            'mi' => 'nullable|string|max:4',
            'designation' => 'nullable|string|max:95',
            'email' => 'nullable|email|max:145',
            'country_code_mobile_bo' => 'nullable',
            'mobile_no_bo' => 'nullable|string|max:15',
             'bcp_salutation' => 'nullable|string|max:10',
            'bcp_fname' => 'nullable|string|max:95',
            'bcp_lname' => 'nullable|string|max:95',
            'bcp_mi' =>  'nullable|string|max:4',
            'bcp_designation' => 'nullable|string|max:95',
            'bcp_email' => 'nullable|email|max:145',
            'bcp_country_code' => 'nullable',
            'bcp_mobile_no' => 'nullable|string|max:12',
        ],[], [
        'salutation' => 'Salutation',
        'fname' => 'First Name',
        'lname' => 'Last Name',
        'mi' => 'Middle Initial',
        'designation' => 'Designation',
        'email' => 'Email',
        'country_code_mobile_bo' => 'Mobile Country Code',
        'mobile_no_bo' => 'Mobile Number',
        'bcp_salutation' => 'Salutation',
        'bcp_fname' => 'First Name',
        'bcp_mi' => 'Middle Initial',
        'bcp_lname' => 'Last Name',
        'bcp_designation' => 'Designation',
        'bcp_email' => 'Email',
        'bcp_country_code' => 'Mobile Country Code',
        'bcp_mobile_no' => 'Mobile Number',
    ]);
        if ($validator2->fails()) {
            return response()->json(['errors' => $validator2->errors()], 422);
        }
        $user->business_owner()->updateOrCreate(
            [
                'uid' => $user->id,
                    'fair_code' => $event_fair_code, 
            ],
            [
                'fair_code' => $event_fair_code,
                'salutation' => $step2_decode['salutation'],
                'fname' => Str::title($step2_decode['fname']),
                'lname' => Str::title($step2_decode['lname']),
                'mi' => Str::upper($step2_decode['mi']),
                'designation' => $step2_decode['designation'],
                'email' => str::lower($step2_decode['email']),
                'country_code' => $step2_decode['country_code_mobile_bo'],
                'mobile_no' => $step2_decode['mobile_no_bo']
            ]
        );

        $user->business_contact_person()->updateOrCreate(
            [
                'uid' => $user->id,
                    'fair_code' => $event_fair_code, 
            ],
            [
                'fair_code' => $event_fair_code,
                'salutation' => $step2_decode['bcp_salutation'],
                'fname' => Str::title($step2_decode['bcp_fname']),
                'lname' => Str::title($step2_decode['bcp_lname']),
                'mi' => Str::upper($step2_decode['bcp_mi']),
                'designation' => $step2_decode['bcp_designation'],
                'email' => str::lower($step2_decode['bcp_email']),
                'country_code' => $step2_decode['bcp_country_code'],
                'mobile_no' => $step2_decode['bcp_mobile_no'],
                'same_as_bo' => $step2_decode['same_as_bo'] ? 1 : 0
            ]
        );
        
        $this->touchExhibitor($user, $event_fair_code);

    } elseif ($request->input('step') == 3) {
$step3_decode = json_decode($request->input('step3_data'), true);

$validator3 = Validator::make(
    $step3_decode,
    [
        'business_type' => 'nullable|integer',
        'company_size' => 'nullable|integer',
        'annual_sales_volume' => 'nullable|integer',
        'organization_type' => 'nullable|integer',
        'product_promoted' => 'nullable|string|max:410',

        'nature_business' => 'nullable|array',
        'target_buyer' => 'nullable|array|max:50',
        'certification' => 'nullable|array|max:50',
        'category' => 'nullable|array|max:200',

        'input_ouput' => 'nullable|array',
        'production_process' => 'nullable|array',
        'sustainability_topics' => 'nullable|array',
    ],

    [
        'required' => ':attribute is required.',
        'integer' => ':attribute must be a valid number.',
        'string' => ':attribute must be valid text.',
        'max' => ':attribute must not exceed :max items.',
        'array' => ':attribute must be an array.',
    ],
 
    [
        'business_type' => 'Business type',
        'company_size' => 'Company size',
        'annual_sales_volume' => 'Annual sales volume',
        'organization_type' => 'Organization type',
        'product_promoted' => 'Product promoted',
        'nature_business' => 'Nature of business',
        'target_buyer' => 'Target buyer(s)',
        'certification' => 'Certification(s)',
        'category' => 'Product category',
        'input_ouput' => 'Input & Output',
        'production_process' => 'Production process',
        'sustainability_topics' => 'Sustainability topics',
    ]
);


if ($validator3->fails()) {
    return response()->json(['errors' => $validator3->errors()], 422);
}

Log::info('Step 3 decoded data:', $step3_decode);
Log::info('Processing Step 3 for user', ['user_id' => $user->id, 'fair_code' => $event_fair_code]);

// Update Exhibitor
$exhibitor = $user->exhibitor()->updateOrCreate(
    [
        'uid' => $user->id,
        'fair_code' => $event_fair_code,
    ],
    [
        'business_type_id'        => $step3_decode['business_type'],
        'start_up' => data_get($step3_decode, 'start_up', false) ? 1 : 0,
        'company_size_id'         => $step3_decode['company_size'],
        'annual_sales_volume_id'  => $step3_decode['annual_sales_volume'],
        'direct_workers'          => $step3_decode['direct'],
        'indirect_workers'        => $step3_decode['indirect'],
        'target_country_export_1' => $step3_decode['target_country_1'],
        'target_country_export_2' => $step3_decode['target_country_2'],
        'target_country_export_3' => $step3_decode['target_country_3'],
        'organization_type_id'    => $step3_decode['organization_type'],
        'industry_rep'            => $step3_decode['industry_representation'],
        'ir_country_exporting_1'  => $step3_decode['exporting_country_1'] ?: null,
        'ir_country_exporting_2'  => $step3_decode['exporting_country_2'] ?: null,
        'ir_country_exporting_3'  => $step3_decode['exporting_country_3'] ?: null,
        'product_promoted'        => $step3_decode['product_promoted'],
        'updated_by' => $authUserId->id,
       
    ]
);

 // Clear participation type if start_up = 1
    if ($step3_decode['start_up'] == 1) {
        if ($attendance) {
            $attendance->timestamps = false; 
            $attendance->participation_type = 1;
            $attendance->save();
            $attendance->timestamps = true;
        }
    }
    
Log::info('Exhibitor updated/created', $exhibitor->toArray());

/*
|--------------------------------------------------------------------------
| NATURE BUSINESS
|--------------------------------------------------------------------------
*/
$user->nature_business()
->where('fair_code', $event_fair_code)
->delete(); // ✅ Deletes all existing entries for this user + fair

$arr_nature_business = collect($step3_decode['nature_business'] ?? [])
->map(function ($nb) use ($step3_decode, $event_fair_code) {
    $nature_business = NatureBusiness::find($nb);
     if (!$nature_business) return null;

     $remarks = $nature_business->id === 16
            ? Str::title($step3_decode['nature_business_others'])
            : $nature_business->name;


    return [
        'nature_business_id' => $nature_business->id,
        'fair_code'          => $event_fair_code,
        'remarks'            => $remarks,
    ];
})
->filter()
->unique(fn($item) => $item['nature_business_id'].'-'.$item['fair_code']) // optional: avoid dupes
->values()
->toArray();

$user->nature_business()->createMany($arr_nature_business);

Log::info('Nature business saved', $arr_nature_business);
/*
|--------------------------------------------------------------------------
| TARGET BUYERS
|--------------------------------------------------------------------------
*/
$user->target_buyer()->where('fair_code', $event_fair_code)->delete();
$arr_target_buyers = collect($step3_decode['target_buyer'] ?? [])
    ->map(function ($target) use ($step3_decode, $event_fair_code) {
        $target_buyer = TargetBuyer::find($target);
        if (!$target_buyer) return null;

        $remarks = $target_buyer->id === 6
            ? Str::title($step3_decode['target_buyer_others'])
            : $target_buyer->name;

        return [
            'target_buyer_id' => $target_buyer->id,
            'fair_code'       => $event_fair_code,
            'remarks'         => $remarks,
        ];
    })
    ->filter()
       ->unique(fn($item) => $item['target_buyer_id'].'-'.$item['fair_code'])
    ->toArray();
$user->target_buyer()->createMany($arr_target_buyers);
Log::info('Target buyers saved', $arr_target_buyers);

/*
|--------------------------------------------------------------------------
| CERTIFICATIONS
|--------------------------------------------------------------------------
*/
$user->certification()->where('fair_code', $event_fair_code)->delete();
$arr_certifications = collect($step3_decode['certification'] ?? [])
    ->map(function ($cert) use ($step3_decode, $event_fair_code) {
        $certification = Certification::find($cert);
        if (!$certification) return null;

        $remarks = $certification->id === 14
            ? Str::title($step3_decode['certification_others'])
            : $certification->name;

        return [
            'certification_id' => $certification->id,
            'fair_code'        => $event_fair_code,
            'remarks'          => $remarks,
        ];
    })
    ->filter()
    ->unique(fn($item) => $item['certification_id'].'-'.$item['fair_code'])
    ->toArray();
$user->certification()->createMany($arr_certifications);
Log::info('Certifications saved', $arr_certifications);

/*
|--------------------------------------------------------------------------
| CATEGORIES & SUB-CATEGORIES
|--------------------------------------------------------------------------
*/
$user->category_subcategory()->where('fair_code', $event_fair_code)->delete();
$arr_categories = collect($step3_decode['category'] ?? [])
    ->map(function ($sub) use ($event_fair_code) {
        $sub_category = SubCategory::find($sub);
        return $sub_category ? [
            'category_id'          => $sub_category->category_id,
            'fair_code'            => $event_fair_code,
            'category_remarks'     => $sub_category->category->name,
            'sub_category_id'      => $sub_category->id,
            'sub_category_remarks' => $sub_category->name,
        ] : null;
    })
    ->filter()
    ->toArray();
$user->category_subcategory()->createMany($arr_categories);
Log::info('Categories & sub-categories saved', $arr_categories);

/*
|--------------------------------------------------------------------------
| SDG
|--------------------------------------------------------------------------
*/
$user->sdg()
->where('fair_code', $event_fair_code)
->delete(); // Deletes all existing entries for this user + fair

$arr_sdg = collect($step3_decode['sdg'] ?? [])
->map(function ($id) use ($event_fair_code) {
    return [
        'fair_code'       => $event_fair_code,
        'sdg_id' => $id,
    ];
})
->filter() // remove nulls or invalid items
->unique(fn($item) => $item['fair_code'] . '-' . $item['sdg_id']) // avoid duplicates
->values()
->toArray();

$user->sdg()->createMany($arr_sdg);

Log::info('SDG saved', $arr_sdg);


/*
|--------------------------------------------------------------------------
| INPUT / OUTPUT
|--------------------------------------------------------------------------
*/
$user->on_input_output()
->where('fair_code', $event_fair_code)
->delete(); // Deletes all existing entries for this user + fair

$arr_input_output = collect($step3_decode['input_ouput'] ?? [])
->map(function ($id) use ($event_fair_code) {
    return [
        'fair_code'       => $event_fair_code,
        'input_output_id' => $id,
    ];
})
->filter() // remove nulls or invalid items
->unique(fn($item) => $item['fair_code'] . '-' . $item['input_output_id']) // avoid duplicates
->values()
->toArray();

$user->on_input_output()->createMany($arr_input_output);

Log::info('Input/Output saved', $arr_input_output);


/*
|--------------------------------------------------------------------------
| PRODUCTION PROCESS
|--------------------------------------------------------------------------
*/
$user->on_production_process()
->where('fair_code', $event_fair_code)
->delete(); // ✅ Delete all existing entries for this user + fair

$arr_production_process = collect($step3_decode['production_process'] ?? [])
->map(function ($pprocess) use ($step3_decode, $event_fair_code) {
    $pp_remarks = $pprocess === 3
        ? Str::title($step3_decode['production_process_others'] ?? '')
        : null;

    return [
        'production_process_id' => $pprocess,
        'fair_code'             => $event_fair_code,
        'other_certification'   => $pp_remarks,
    ];
})
->filter() // ✅ Remove null/invalid
->unique(fn($item) => $item['fair_code'] . '-' . $item['production_process_id']) // ✅ Avoid duplicates
->values()
->toArray();

if (!empty($arr_production_process)) {
$user->on_production_process()->createMany($arr_production_process);
}

Log::info('Production process saved', $arr_production_process);

/*
|--------------------------------------------------------------------------
| TOPIC PICK
|--------------------------------------------------------------------------
*/
$user->topic_pick()->where('fair_code', $event_fair_code)->delete();
$arr_topic_picks = collect($step3_decode['sustainability_topics'] ?? [])
    ->map(fn($topicId) => [
        'topic_id'  => $topicId,
        'fair_code' => $event_fair_code,
    ])
    ->toArray();
$user->topic_pick()->createMany($arr_topic_picks);
Log::info('Topic picks saved', $arr_topic_picks);
$this->touchExhibitor($user, $event_fair_code);


Log::info('Step 3 processing finished', ['user_id' => $user->id]);

 return response()->json([
        'business_type' => $exhibitor->business_type_id,
        'start_up' => $exhibitor->start_up,
    ], 200);

    } elseif ($request->input('step') == 4) {
      
     

        $step4_decode = json_decode($request->input('step4_data'), true);
      
            $isFullyApproved = filter_var(
        $request->input('is_fully_approved_by_reviewer_and_conforme_reviewed'),
        FILTER_VALIDATE_BOOLEAN
        );

         if ($attendance) {
            $attendance->timestamps = false; 
            $attendance->conference_response = $step4_decode['conference_response'] ?? null;
                if (!$isFullyApproved) {
                    $attendance->participation_type =
                    $step4_decode['participation_type'] ?? null;
                }
            $attendance->sponsorship_response = $step4_decode['sponsorship_response'] ?? null;
            $attendance->save();
            $attendance->timestamps = true;
        }

          Log::info('Step 4 participation_type', [
        'user_id' => $user->id,
        'fair_code' => $event_fair_code,
        'value' => $step4_decode['participation_type'] ?? null
    ]);

        $this->touchExhibitor($user, $event_fair_code);
     
        } else {
// FINAL STEP: Handle Documents
$docFields = [
    'doc1' => 'dti_sec',
    'doc2' => 'bir',
    'doc3' => 'lto',
    'doc4' => 'cpr',
    'doc5' => 'other_food_certificate',
    'doc6' => 'institutional_catalog',
    'doc7' => 'business_certification',
    'doc8' => 'food_or_environmental_certification'
];



// Scope exhibitor by fair_code (just like in Step 1 & Step 3)
$exhibitor = $user->exhibitorForFair($event_fair_code);
$businessType = optional($exhibitor)->business_type_id;

$docRules = [];
foreach ($docFields as $input => $column) {
    $docRules[$input] = 'nullable|mimes:pdf,jpg,jpeg,png|max:1024';
}

$docValidator = Validator::make($request->all(), $docRules);
if ($docValidator->fails()) {
    return response()->json(['errors' => $docValidator->errors()], 422);
}

$docs = [];

   // Fetch existing documents for this fair_code
    $existingDocs = $user->exhibitorDocumentFor($event_fair_code)->first();
    $docs = [];

   foreach ($docFields as $input => $column) {
        $currentValue = optional($existingDocs)->{$column};

        if ($request->hasFile($input)) {
            // Delete old file if exists
            if ($currentValue && Storage::exists($currentValue)) {
                Storage::delete($currentValue);
            }
            // Store new file
            $docs[$column] = $request->file($input)->store('public/documents', 'local');
        } else {
            // Keep old file
            $docs[$column] = $currentValue;
        }
    }


$type3 = ['dti_sec', 'bir', 'lto', 'cpr', 'other_food_certificate'];
$type1and2 = ['business_certification', 'food_or_environmental_certification'];

// Force local doc fields to null depending on business type
if ($businessType == 3) {
    foreach ($type3 as $column) {
        $currentValue = optional($user->document)->{$column};
        if ($currentValue && Storage::exists($currentValue)) {
            Storage::delete($currentValue);
        }
        $docs[$column] = null;
    }
} else {
    foreach ($type1and2 as $column) {
        $currentValue = optional($user->document)->{$column};
        if ($currentValue && Storage::exists($currentValue)) {
            Storage::delete($currentValue);
        }
        $docs[$column] = null;
    }
}

   // Update or create documents for this fair_code
    if ($existingDocs) {
        foreach ($docs as $key => $value) {
            $existingDocs->{$key} = $value;
        }
        $existingDocs->save();
    } else {
        $user->document()->create(array_merge(
            ['uid' => $user->id, 'fair_code' => $event_fair_code],
            $docs
        ));
    }

// $user->exhibitorAttendances()->updateOrCreate(
//     ['fair_code' => $event_fair_code], 
//     ['status' => 2]             
// );

// ✅ SAFER version: only update new uploads, preserve existing docs
$existingDocs = $user->exhibitorDocumentFor($event_fair_code)->first();

if ($existingDocs) {
    // Update only the new docs (don’t erase old ones)
    foreach ($docs as $key => $value) {
        if (!empty($value)) {
            $existingDocs->{$key} = $value;
        }
    }
    $existingDocs->save();
} else {
    // Create if doesn’t exist
    $user->document()->create(array_merge(
        ['uid' => $user->id, 'fair_code' => $event_fair_code],
        $docs
    ));
}

//  Handle agreements
$data = [];

if ($request->filled('registration_agreement_id')) {
    $data['registration_agreement_id'] = $request->input('registration_agreement_id');
    $data['registration_agreement_status'] = 1;
    $data['registration_agreement_agreed_at'] = now();
}

if ($request->filled('privacy_policy_id')) {
    $data['privacy_policy_id'] = $request->input('privacy_policy_id');
    $data['privacy_policy_status'] = 1;
    $data['privacy_policy_agreed_at'] = now();
}

// Only update if there’s at least one agreement
if (!empty($data)) {
    ExhibitorAttendance::updateOrCreate(
        [
            'user_id'   => $user->id,
            'fair_code' => $event_fair_code,
        ],
        $data
    );
}
}

//  if (env('SSX_API_SYNC')) {
//             $this->citemAPIUpdateExhibitorForFair($user->id, $event_fair_code);
//             if ($status) {
//                 $this->citemAPIValidateStatus($user->email, $status, $user->user_group);
//             }
//         }

return response()->json(true, 200);
}

public function approve(Request $request, $id)
{
    $user = User::findOrFail($id);
    $fair_code = $request->fair_code;
    $event = Event::where('fair_code', $fair_code)->first();
    $exhibitor = $user->exhibitorForFair( $fair_code);
    
    if ($user->user_group === 5) {

         $attendance = $user->exhibitorAttendanceForFair($fair_code);



        if ($exhibitor) {
            $exhibitor->update([
                'approved_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        }

        // ✅ Update Exhibitor Attendance status
        $attendance = $user->exhibitorAttendanceForFair($fair_code);

        if ($attendance) {
            $attendance->update([
                'status' => 1, // approved
            ]);
        }

        $attendance->timestamps = false;
        $attendance->participation_type = $request->participation_type ?? null;
        $attendance->save();
        $attendance->timestamps = true;

        $this->touchExhibitor($user, $fair_code);

            
// $BCC_Accounting = $this->parseEmailList(env('BCC_Accounting'));

//     if (env('APP_ENV') != 'local') {
//         Mail::to($BCC_Accounting)->send(new ApprovedApplication($user, $exhibitor , $event));
//     } else {
//         Mail::to('kgtecson.citem@gmail.com')->send(new ApprovedApplication($user, $exhibitor, $event));
//     }

    } else {
        // ✅ BUYER
         $buyer = $user->buyerForFair($fair_code);

        if ($buyer) {
            $buyer->update([
                'approved_by' => Auth::id(),
                'updated_by'  => Auth::id(),
            ]);
        }

        $attendance = $user->buyerAttendanceForFair($fair_code);

        if ($attendance) {
            $attendance->update([
                'status'     => 1, // reviewed
            ]);
        }

        $this->touchBuyer($user, $fair_code);
      
        $mail = new BuyerApprovedApplication($user, $buyer, $fair_code);

   if (env('APP_ENV') != 'local') {
            Mail::to($user->email)->send( $mail);
        } else {
            Mail::to('kgtecson.citem@gmail.com')->send( $mail);
        }
    }

   
    

    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIValidateStatus($user->email, 'approved', $user->user_group);
    // }
 


    return response()->json(true, 200);
}

public function deny(Request $request, $id)
{
    $user = User::findOrFail($id);
    $fair_code = $request->fair_code;

if ($user->user_group === 5) {
    
    $exhibitor = $user->exhibitorForFair($fair_code);

    if ($exhibitor) {
        $exhibitor->update([
            'disapproved_by' => Auth::id(),
            'updated_by'  => Auth::id(),
        ]);
    }

    // ✅ Update Exhibitor Attendance status
    $attendance = $user->exhibitorAttendanceForFair($fair_code);

    if ($attendance) {
        $attendance->update([
            'status'     => 5, // reviewed
        ]);
    }
$this->touchExhibitor($user, $fair_code);
}  else {
        //BUYER
            $buyer = $user->buyerForFair($fair_code);

    if ($buyer) {
        $buyer->update([
            'disapproved_by' => Auth::id(),
            'updated_by'  => Auth::id(),
        ]);
    }

    $attendance = $user->buyerAttendanceForFair($fair_code);

    if ($attendance) {
        $attendance->update([
            'status'     => 5, 
        ]);
    }
    $this->touchBuyer($user, $fair_code);
    }
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIValidateStatus($user->email, 'disapproved', $user->user_group);
    // }
    if (env('APP_ENV') != 'local') {
        Mail::to(strtolower($user->email))->send(new DeniedApplication($user->id));
    } else {
        Mail::to('kgtecson.citem@gmail.com')->send(new DeniedApplication($user->id));
    }
    return response()->json(true, 200);
}

public function onhold(Request $request, $id)
{
    $user = User::findOrFail($id);
$fair_code = $request->fair_code;

if ($user->user_group === 5) {

$exhibitor = $user->exhibitorForFair($fair_code);

if ($exhibitor) {
    $exhibitor->update([
        'onhold_by' => Auth::id(),
        'updated_by'  => Auth::id(),
    ]);
}

// ✅ Update Exhibitor Attendance status
$attendance = $user->exhibitorAttendanceForFair($fair_code);

if ($attendance) {
    $attendance->update([
        'status'     => 4, // reviewed
    ]);
}

    $this->touchExhibitor($user, $fair_code);

}  else {
    //BUYER
        //BUYER
        $buyer = $user->buyerForFair($fair_code);

if ($buyer) {
    $buyer->update([
        'onhold_by' => Auth::id(),
        'updated_by'  => Auth::id(),
    ]);
}

$attendance = $user->buyerAttendanceForFair($fair_code);

if ($attendance) {
    $attendance->update([
        'status'     => 4, 
    ]);
}

    $this->touchBuyer($user, $fair_code);
}

// if (env('SSX_API_SYNC')) {
//     $this->citemAPIValidateStatus($user->email, 'waitlisted', $user->user_group);
// }

return response()->json(true, 200);
}
   
public function supplier_product_store(Request $request)
{
    $user = User::findOrFail($request->input('user_id'));

    $prod_info = json_decode($request->input('prod_info'), true);

    $product = $user->products()->updateOrCreate(
        [
            'id' => $request->input('product_id')
        ],
        [
            'name' => $prod_info['prod_name'],
            'slug' => Str::of($prod_info['prod_name'])->slug('-'),
            'description' => $prod_info['prod_details'],
            'store_url' => $prod_info['store_url'],
            'status' => $user->status === 1 ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]
    );

    $destinationPath = storage_path('app/public/exhibitors/products');
    $arr_product_images = [];
    if (!empty($prod_info['prod_images_for_upload'])) {
        foreach ($prod_info['prod_images_for_upload'] as $key => $photo) {
            $filename = md5(time()).'_'.uniqid().'.'.$photo['ext'];
            $productImage = Image::make($photo['urlResized']);
            $size = $productImage->filesize();

            $productImage->fit(360, 200, function ($constraint1) {
                $constraint1->upsize();
            });
            $productImage->save($destinationPath.'/thumbs/'.$filename);

            $productImage->fit(800, 620, function ($constraint2) {
                $constraint2->upsize();
            });
            
            $productImage->save($destinationPath.'/'.$filename);

            $arr_product_images[] = [
                'image' => $filename,
                'img_size' => $size,
                'img_type' => 'image/'.$photo['ext'],
                'img_ext' => $photo['ext']
            ];
        }
        $product->product_images()->createMany($arr_product_images);
    }
    //Categories & Sub-Categories
    if (!empty($product->product_profiles)) {
        $product->product_profiles()->delete();
    }
    $arr_categories = [];
    foreach ($prod_info['prod_profiles'] as $sub) {
        $sub_category = SubCategory::find($sub);
        if (!empty($sub_category)) {
            $arr_categories[] = [
                'category_id' => $sub_category->category_id,
                'category_remarks' => $sub_category->category->name,
                'sub_category_id' => $sub_category->id,
                'sub_category_remarks' => $sub_category->name
            ];
        }
    }
    $product->product_profiles()->createMany($arr_categories);

    //CERTIFICATIONS
    if (!empty($product->product_certifications)) {
        $product->product_certifications()->delete();
    }
    $arr_certifications = [];
    foreach ($prod_info['prod_certs'] as $cert) {
        $certification = Certification::find($cert);
        if (!empty($certification)) {
            if ($certification->id === 14) {
                $remarks = Str::title($prod_info['certs_others']);
            } else {
                $remarks = $certification->name;
            }
            $arr_certifications[] = [
                'certification_id' => $certification->id,
                'remarks' => $remarks
            ];
        }
    }
    $product->product_certifications()->createMany($arr_certifications);

    return response()->json(true, 200);
}

//! Conforme
 public function conforme_review(Request $request)
{
    // Validate the request
    $request->validate([
        'id' => 'required|integer|exists:users,id',
        'fair_code' => 'required|string',
        'conforme_reviewed' => 'required|integer', // 0 or 1
    ]);

    $user = User::findOrFail($request->id);
    $fair_code = $request->fair_code;

    // Only handle Exhibitors
    if ($user->user_group !== 5) {
        return response()->json([
            'success' => false,
            'message' => 'Conforme review is only for exhibitors.'
        ], 400);
    }

    // Get the attendance record for this fair
    $attendance = $user->exhibitorAttendanceForFair($fair_code);

    if (!$attendance) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor attendance not found for this fair.'
        ], 404);
    }

    $exhibitor = $user->exhibitorForFair($fair_code);

    // $attendance->timestamps = false;
    $attendance->participation_type = $request->participation_type ?? null;
    $attendance->conforme_review = $request->conforme_reviewed;
    $attendance->conforme_review_date = now();
    $attendance->conforme_by = Auth::id();
    $attendance->save();

    // Re-enable timestamps
    // $attendance->timestamps = true;

    $this->touchExhibitor($user, $fair_code);

    // Generate PDF and get token
    $result = $this->generate_pdf($user->id, $fair_code);
    $pdfPath = $result['pdf_path'] ?? null;
    $token = $result['token'] ?? null;

    $recipientEmail = env('APP_ENV') != 'local'
        ? ($exhibitor->co_email ?? $user->email)
        : 'kgtecson.citem@gmail.com';

    // Send emails with token
    if (env('APP_ENV') != 'local') {
        Mail::to($recipientEmail)->send(
            new SupplierConformeValidation($user, $exhibitor, $fair_code, $pdfPath, $token)
        );
    } else {
        Mail::to('kgtecson.citem@gmail.com')->send(
            new SupplierConformeValidation($user, $exhibitor, $fair_code, $pdfPath, $token)
        );
    }

    // Optional API sync
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIValidateStatus($user->email, 'conforme_reviewed', $user->user_group);
    // }


    return response()->json([
        'success' => true,
        'message' => 'Conforme generation submitted successfully.',
        'conforme_reviewed' => $attendance->conforme_review,
    ]);
}

public function resend_conforme(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:users,id',
        'fair_code' => 'required|string',
    ]);

    $user = User::findOrFail($request->id);
    $fair_code = $request->fair_code;

    // Only handle Exhibitors
    if ($user->user_group !== 5) {
        return response()->json([
            'success' => false,
            'message' => 'Conforme resend is only for exhibitors.',
        ], 400);
    }

    // Get attendance for this fair
    $attendance = $user->exhibitorAttendanceForFair($fair_code);

    if (!$attendance) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor attendance not found for this fair.',
        ], 404);
    }

    // Make sure conforme was already generated
    if (!$attendance->conforme_review) {
        return response()->json([
            'success' => false,
            'message' => 'Conforme has not been generated yet.',
        ], 400);
    }

    $exhibitor = $user->exhibitorForFair($fair_code);

    if (!$exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Get the existing/latest Conforme
    |--------------------------------------------------------------------------
    */

    $latestConforme = $attendance->latestConforme;

    if (!$latestConforme) {
        return response()->json([
            'success' => false,
            'message' => 'No existing conforme record was found.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Existing PDF + Token
    |--------------------------------------------------------------------------
    */

    $pdfPath = $latestConforme->noa_file ?? null;
    $token = $latestConforme->email_token ?? null;

    if (!$pdfPath) {
        return response()->json([
            'success' => false,
            'message' => 'The existing conforme PDF could not be found.',
        ], 404);
    }

    /*
    |--------------------------------------------------------------------------
    | Recipient
    |--------------------------------------------------------------------------
    */

    $recipientEmail = env('APP_ENV') != 'local'
        ? ($exhibitor->co_email ?? $user->email)
        : 'kgtecson.citem@gmail.com';

    /*
    |--------------------------------------------------------------------------
    | Resend Existing Conforme
    |--------------------------------------------------------------------------
    */

    if (env('APP_ENV') != 'local') {
        Mail::to($recipientEmail)->send(
            new SupplierConformeValidation(
                $user,
                $exhibitor,
                $fair_code,
                $pdfPath,
                $token
            )
        );
    } else {
        Mail::to('kgtecson.citem@gmail.com')->send(
            new SupplierConformeValidation(
                $user,
                $exhibitor,
                $fair_code,
                $pdfPath,
                $token
            )
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Conforme resent successfully.',
    ]);
}

//! End Accounting

//! Conforme pdf generation
public function generate_pdf($id, $fair_code){
    try {
        Log::info('generate_pdf() called', compact('id', 'fair_code'));

        /** ---------------------------------------------------
         *  FETCH USER
         * ---------------------------------------------------- */
        $user = User::find($id);
        if (!$user) {
            Log::error('User not found', compact('id'));
            return false;
        }

        if ((int)$user->user_group !== 5) {
            Log::info('Not exhibitor user_group', ['user_group' => $user->user_group]);
            return false;
        }

        /** ---------------------------------------------------
         *  FETCH EXHIBITOR + ATTENDANCE
         * ---------------------------------------------------- */
        $exhibitor = $user->exhibitorForFair($fair_code);
        if (!$exhibitor) {
            Log::warning('No exhibitor for fair', compact('id', 'fair_code'));
            return false;
        }

     $attendance_info = $user->exhibitorAttendanceForFair($fair_code)
    ->load([
        'registrationAgreement',
        'soaAgreement',
        'privacyPolicy',
        'informationSharing'
    ]);

        $agreements = $attendance_info->agreements;
        $business_owner_for_fair = $user->businessOwnerForFair($fair_code)->first();
        $business_contact_person_for_fair = $user->businessContactPersonForFair($fair_code)->first();

        $certification = $user->certificationForFair($fair_code);
        $certificate_for_fair = $certification->pluck('remarks')->implode(', ') ?: 'N/A';

        /** ---------------------------------------------------
         *  EXPORTING / TARGET COUNTRIES
         * ---------------------------------------------------- */
        $export_target_countries_for_fair = collect([
            $exhibitor->country_target_buyer_export_1 ? $exhibitor->country_target_buyer_export_1->name : null,
            $exhibitor->country_target_buyer_export_2 ? $exhibitor->country_target_buyer_export_2->name : null,
            $exhibitor->country_target_buyer_export_3 ? $exhibitor->country_target_buyer_export_3->name : null,
        ])->filter()->implode(', ') ?: 'N/A';

        $exporting_exp_for_fair = '';
        if ($exhibitor->industry_rep === 1) {
            $exporting_exp_for_fair = collect([
                $exhibitor->country_exporting_to_1 ? $exhibitor->country_exporting_to_1->name : null,
                $exhibitor->country_exporting_to_2 ? $exhibitor->country_exporting_to_2->name : null,
                $exhibitor->country_exporting_to_3 ? $exhibitor->country_exporting_to_3->name : null,
            ])->filter()->implode(', ') ?: 'N/A';
        }

        /** ---------------------------------------------------
         *  PRODUCT CATEGORY
         * ---------------------------------------------------- */
        $subcategory_exp_for_fair = $user->categorySubcategoryForFair($fair_code)
            ->pluck('sub_category_remarks')
            ->map(function($v) { return ucwords($v); })
            ->implode(', ') ?: 'N/A';

        /** ---------------------------------------------------
         *  FETCH EVENT ---------------------------------------
         * ---------------------------------------------------- */
        $event = Event::where('fair_code', $fair_code)->first();

        /** ---------------------------------------------------
         *  NATURE OF BUSINESS / TARGET BUYERS ----------------
         * ---------------------------------------------------- */
        $nature_business_for_fair = $user->exhibitorBuyerNatureBusinessForFair($fair_code)
            ->with('natureBusiness')
            ->get()
            ->map(function($item) {
                return $item->remarks ?: ($item->natureBusiness ? $item->natureBusiness->name : 'N/A');
            })
            ->implode(', ') ?: 'N/A';

        $target_buyers_for_fair = $user->exhibitorTargetBuyersForFair($fair_code)
            ->with('targetBuyer')
            ->get()
            ->map(function($item) {
                return $item->remarks ?: ($item->targetBuyer ? $item->targetBuyer->name : 'N/A');
            })
            ->implode(', ') ?: 'N/A';

        /** ---------------------------------------------------
         *  INPUT / OUTPUT & PRODUCTION PROCESS ---------------
         * ---------------------------------------------------- */


           $on_sdg_for_fair = $user->sdgForFair($fair_code)
            ->with('product_char_sdg')
            ->get();

        $on_input_output_for_fair = $user->inputOutputForFair($fair_code)
            ->with('product_char_inputoutput')
            ->get();

        $on_production_process_for_fair = $user->productionProcessForFair($fair_code)
            ->with('product_char_prod_process')
            ->get();

        /** ---------------------------------------------------
         *  TOPIC PICKS ---------------------------------------
         * ---------------------------------------------------- */
        $topic_picks_for_fair = $user->topicPicksForFair($fair_code)
            ->with('focus_topic')
            ->get();

        /** ---------------------------------------------------
         *  PARTICIPATION CART --------------------------------
         * ---------------------------------------------------- */
        $cart = Exhibitor::with([
            'participationSelections' => function($q) use ($fair_code) {
                $q->where('fair_code', $fair_code);
            },
            'participationSelections.package:id,title,sub_title,booth_details',
            'participationSelections.space:id,name',
            'participationSelections.size',
        ])
        ->where('uid', $user->id)
        ->first();

        $cartItems = [];
        if ($cart && $cart->participationSelections) {
            $cartItems = $cart->participationSelections->map(function($item) {
                return [
                    'id' => $item->id,
                    'package_title' => $item->package ? $item->package->title : '',
                    'package_sub_title' => $item->package ? $item->package->sub_title : '',
                    'space_name' => $item->space ? $item->space->name : '',
                    'booth_details' => $item->package ? $item->package->booth_details : '',
                    'booth_size_name' => $item->booth_size_name ?: '',
                    'booth_qty' => $item->booth_qty  ?: 0,
                    'total_participation' => $item->total_participation ?: 0,
                    'discount' => $item->discount ?: 0,
                    'discount_remarks' => $item->discount_remarks ?: '',
                    'total_amount_due' => $item->total_amount_due ?: 0,
                    'currency' => $item->currency ?: '',
                ];
            })->toArray();
        }

        /** ---------------------------------------------------
         *  DISCOUNTS & ADDITIONAL FEES -----------------------
         * ---------------------------------------------------- */
        $discountItems = Discounts::where('ff_code', $user->id)
            ->where('fair_code', $fair_code)
            ->get()
            ->map(function($d) {
                return [
                    'remarks' => $d->remarks,
                    'amount' => $d->amount,
                    'currency' => $d->currency,
                    'type' => $d->type,
                ];
            })->toArray();

        $additionalFeesItems = AdditionalFees::where('ff_code', $user->id)
            ->where('fair_code', $fair_code)
            ->get()
            ->map(function($d) {
                return [
                    'remarks' => $d->remarks,
                    'amount' => $d->amount,
                    'currency' => $d->currency,
                    'type' => $d->type,
                ];
            })->toArray();

        /** ---------------------------------------------------
         *  MANDATORY FEE -------------------------------------
         * ---------------------------------------------------- */
        $mandatory = ParticipationMandatory::where('business_type_id', $exhibitor->business_type_id)->first();
        $mandatoryData = $mandatory ? [
            'id' => $mandatory->id,
            'details' => $mandatory->details,
            'price' => $mandatory->price,
            'currency' => $mandatory->currency,
        ] : null;

        /** ---------------------------------------------------
         *  ADD-ONS -------------------------------------------
         * ---------------------------------------------------- */
        $addonSelections = ParticipationAddOnSelection::with(['addOn','addOnRates'])
            ->where('ff_code', $user->id)
            ->where('fair_code', $fair_code)
            ->get();

        $addonItems = [];
        foreach ($addonSelections as $selection) {
            $rate = $selection->addOnRates->where('business_type_id', $exhibitor->business_type_id)->first();
            $addonItems[] = [
                'id' => $selection->id,
                'addon_name' => $selection->addOn ? $selection->addOn->name : 'N/A',
                'unit' => $selection->addOn ? $selection->addOn->unit : 'N/A',
                'qty' => $selection->qty ?: 0,
                'qty_type' => $selection->addOn ? $selection->addOn->qty_type : 'N/A',
                'limit_per_exhibitor' => $selection->addOn ? $selection->addOn->limit_per_exhibitor : 'N/A',
                'currency' => $rate ? $rate->currency : 'N/A',
                'rate_cost' => $rate ? $rate->cost : 0,
                'total_amount_due' => $selection->total_amount_due ?: 0,
            ];
        }

        /** ---------------------------------------------------
         *  DOCUMENTS -----------------------------------------
         * ---------------------------------------------------- */
        $document_for_fair = $user->exhibitorDocumentFor($fair_code)->first();
        $docsList = ['dti_sec','bir','lto','cpr','other_food_certificate','institutional_catalog','business_certification'];
        foreach ($docsList as $index => $docField) {
            if ($document_for_fair && !empty($document_for_fair->$docField) && Storage::exists($document_for_fair->$docField)) {
                $user['doc'.($index+1)] = pathinfo($document_for_fair->$docField);
                $user['doc'.($index+1).'_url'] = Storage::url($document_for_fair->$docField);
                $user['doc'.($index+1).'_filesize'] = Storage::size($document_for_fair->$docField);
            }
        }

        /** ---------------------------------------------------
         *  FILE PREP -----------------------------------------
         * ---------------------------------------------------- */
        $path = storage_path('app/public/noa/');
        if (!file_exists($path)) mkdir($path, 0755, true);

        $token = $this->generateToken($user);

        $version = $this->getNextPdfVersionNumber($user->id, $fair_code);
        $filename = $user->id
    . "_{$fair_code}_"
    . $this->formatPdfVersion($version)
    . "_{$token}.pdf";
        $fullPath = $path . $filename;

        /** ---------------------------------------------------
         *  DATA FOR PDF --------------------------------------
         * ---------------------------------------------------- */
        $data = [
            'cur_date' => Carbon::now()->format('jS \\o\\f F, Y'),
            'user' => $user,
            'exhibitor' => $exhibitor,
            'attendance_info' => $attendance_info,
            'agreements' => $agreements,
            'b_owner' => $business_owner_for_fair,
            'b_contact_person' => $business_contact_person_for_fair,
            'nature_business' => $nature_business_for_fair,
            'target_buyers' => $target_buyers_for_fair,
            'certification' => $certificate_for_fair,
            'industry_rep_countries' => $exporting_exp_for_fair,
            'target_countries' => $export_target_countries_for_fair,
            'prod_category' => $subcategory_exp_for_fair,
            'cart_items' => $cartItems,
            'additional_fees_items' => $additionalFeesItems,
            'discount_items' => $discountItems,
            'mandatory_fee' => $mandatoryData,
            'addon_items' => $addonItems,
            'event' => $event,
            'docs' => $document_for_fair,
            'on_sdg' => $on_sdg_for_fair->pluck('product_char_sdg.name')->toArray(),
            'on_input_output' => $on_input_output_for_fair->pluck('product_char_inputoutput.name')->toArray(),
            'on_production_process' => $on_production_process_for_fair->pluck('product_char_prod_process.name')->toArray(),
            'topic_picks' => $topic_picks_for_fair->pluck('focus_topic.name')->toArray(),
        ];

        /** ---------------------------------------------------
         *  GENERATE PDF --------------------------------------             
         * ---------------------------------------------------- */
        $pdf = PDF::loadView('website.registration.supplier.summary', $data)
            ->setOptions([
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true
            ]);
        $pdf->save($fullPath);

        /** ---------------------------------------------------
         *  SAVE RECORD ---------------------------------------
         * ---------------------------------------------------- */
    

        Conforme::create([
            'ff_code' => $user->id,
            'fair_code' => $fair_code,
            'email_token' => $token,
            'recipient_email' => $user->email,
            'noa_file' => "noa/$filename",
            'date_sent' => Carbon::now(),
        ]);

        Log::info('PDF generated successfully', ['path' => $fullPath]);

        return [
            'pdf_path' => $fullPath,
            'token' => $token,
        ];

    } catch (\Throwable $e) {
        Log::error('Error in generate_pdf()', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return false;
    }
}
//! End Conforme pdf generation


//! Additional Fees 
public function add_additional_fees(Request $request)
{
    $validated = $request->validate([
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
        'remark'    => 'required|string|max:255',
        'amount'    => 'required|numeric|min:0',
        'currency'  => 'required|string|max:10',
        'type'      => 'required|string|in:additional',
    ]);

    $authId = auth()->id();

    $user = User::findOrFail($validated['ff_code']);

    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    $fee = AdditionalFees::create([
        'ff_code'    => $validated['ff_code'],
        'fair_code'  => $validated['fair_code'],
        'remarks'    => $validated['remark'],
        'amount'     => $validated['amount'],
        'currency'   => $validated['currency'],
        'type'       => $validated['type'],
        'added_by'   => $authId,
        'updated_by' => $authId,
    ]);

    if ($authId !== null) {

        $description = [
            'action' => 'add_additional_fee',
            'message' => 'Additional fee added successfully.',
            'fee' => [
                'id'       => $fee->id,
                'type'     => $validated['type'],
                'amount'   => $validated['amount'],
                'currency' => $validated['currency'],
                'remark'   => $validated['remark'],
            ],
            'meta' => [
                'fair_code' => $validated['fair_code'],
                'ff_code'   => $validated['ff_code'],
                'added_by'  => $authId,
            ],
        ];

        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['ff_code'],
            'add',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Additional fee added successfully.',
        'data'    => $fee,
    ], 200);
}

 public function delete_additional_fees_cart_item(Request $request)
{
    $validated = $request->validate([
        'additional_fee_cart_item_id' => 'required|integer|exists:additional_fees,id',
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $authId = auth()->id();

    // Fetch user
    $user = User::find($validated['ff_code']);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Validate exhibitor
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Fetch fee
    $fee = AdditionalFees::where('id', $validated['additional_fee_cart_item_id'])
        ->where('ff_code', $validated['ff_code'])
        ->where('fair_code', $validated['fair_code'])
        ->first();

    if (! $fee) {
        return response()->json([
            'success' => false,
            'message' => 'Additional fee item not found.',
        ], 404);
    }

    // Cache data for history BEFORE delete
    $description = [
        'action'  => 'delete_additional_fees_cart_item',
        'message' => 'Additional fee deleted successfully.',
        'fee' => [
            'id'       => $fee->id,
            'type'     => $fee->type,
            'amount'   => $fee->amount,
            'currency' => $fee->currency,
            'remark'   => $fee->remarks,
        ],
        'meta' => [
            'fair_code' => $validated['fair_code'],
            'ff_code'   => $validated['ff_code'],
            'deleted_by'=> $authId,
        ],
    ];

    // Delete fee
    $fee->delete();

    // 🧾 Log history
    if ($authId !== null) {
        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['ff_code'],
            'delete',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Additional fee deleted successfully.',
    ], 200);
}

public function delete_all_additional_fees_cart_items(Request $request)
{
    $validated = $request->validate([
        'user_id'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $authId = auth()->id();

    $user = User::findOrFail($validated['user_id']);
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);

    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    // ✅ Use users.id
    $feesQuery = AdditionalFees::where('ff_code', $validated['user_id'])
        ->where('fair_code', $validated['fair_code']);

    $feesCount = $feesQuery->count();

    if ($feesCount === 0) {
        return response()->json([
            'success' => true,
            'message' => 'No additional fee items found. Nothing to delete.',
            'empty'   => true,
        ], 200);
    }

    
    $description = [
        'action'  => 'delete_all_additional_fees_cart_items',
        'message' => 'All additional fee items deleted successfully.',
        'summary' => [
            'deleted_count' => $feesCount,
        ],
        'meta' => [
            'fair_code'  => $validated['fair_code'],
            'ff_code'    => $validated['user_id'],
            'deleted_by' => $authId,
        ],
    ];

    // Delete all
    $feesQuery->delete();

    // Log once
    if ($authId !== null) {
        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['user_id'],
            'delete',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'All additional fee items deleted successfully.',
        'deleted' => $feesCount,
    ], 200);
}


    //! End Additional Discounts

    //! Discounts
    
    public function add_discount(Request $request)
{
    // Validate request
    $validated = $request->validate([
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
        'remark'    => 'required|string|max:255',
        'amount'    => 'required|numeric|min:0',
        'currency'  => 'required|string|max:10',
        'type'      => 'required|string|in:discount',
    ]);

    $authId = auth()->id();

    // Find user
    $user = User::findOrFail($validated['ff_code']);

    // Check exhibitor
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Create discount
    $discount = Discounts::create([
        'ff_code'    => $validated['ff_code'],
        'fair_code'  => $validated['fair_code'],
        'remarks'    => $validated['remark'],
        'amount'     => $validated['amount'],
        'currency'   => $validated['currency'],
        'type'       => $validated['type'],
        'added_by'   => $authId,
        'updated_by' => $authId,
    ]);

 
    if ($authId !== null) {
        $description = [
            'action'  => 'add_discount',
            'message' => 'Discount added successfully.',
            'discount' => [
                'id'       => $discount->id,
                'amount'   => $discount->amount,
                'currency' => $discount->currency,
                'remark'   => $discount->remarks,
                'type'     => $discount->type,
            ],
            'meta' => [
                'fair_code' => $validated['fair_code'],
                'ff_code'   => $validated['ff_code'],
                'added_by'  => $authId,
            ],
        ];

        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['ff_code'],
            'add',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Discount added successfully.',
        'data'    => $discount,
    ], 200);
}
    public function delete_discount_cart_item(Request $request)
{
    // Validate request
    $validated = $request->validate([
        'discount_cart_item_id' => 'required|integer|exists:discounts,id',
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $authId = auth()->id();

    // Fetch user
    $user = User::find($validated['ff_code']);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Validate exhibitor
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Fetch discount
    $discount = Discounts::where('id', $validated['discount_cart_item_id'])
        ->where('ff_code', $validated['ff_code'])
        ->where('fair_code', $validated['fair_code'])
        ->first();

    if (! $discount) {
        return response()->json([
            'success' => false,
            'message' => 'Discount item not found.',
        ], 404);
    }

    // Cache details for history BEFORE delete
    $description = [
        'action'  => 'delete_discount_cart_item',
        'message' => 'Discount deleted successfully.',
        'discount' => [
            'id'       => $discount->id,
            'amount'   => $discount->amount,
            'currency' => $discount->currency,
            'remark'   => $discount->remarks,
            'type'     => $discount->type,
        ],
        'meta' => [
            'fair_code'   => $validated['fair_code'],
            'ff_code'     => $validated['ff_code'],
            'deleted_by'  => $authId,
        ],
    ];

    // Delete discount
    $discount->delete();

    // Log history
    if ($authId !== null) {
        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['ff_code'],
            'delete',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'Discount deleted successfully.',
    ], 200);
}

   public function delete_all_discount_cart_items(Request $request)
{
    $validated = $request->validate([
        'user_id'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $authId = auth()->id();

    $user = User::findOrFail($validated['user_id']);
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);

    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    // Query discounts
    $discountQuery = Discounts::where('ff_code', $validated['user_id'])
        ->where('fair_code', $validated['fair_code']);

    $discountCount = $discountQuery->count();

    // Nothing to delete
    if ($discountCount === 0) {
        return response()->json([
            'success' => true,
            'message' => 'No discount items found. Nothing to delete.',
            'empty'   => true,
        ], 200);
    }

    // Prepare JSON description BEFORE deletion
    $description = [
        'action'  => 'delete_all_discount_cart_items',
        'message' => 'All discount items deleted successfully.',
        'summary' => [
            'deleted_count' => $discountCount,
        ],
        'meta' => [
            'fair_code'  => $validated['fair_code'],
            'ff_code'    => $validated['user_id'],
            'deleted_by' => $authId,
        ],
    ];

    // Delete all discounts
    $discountQuery->delete();

    // Log history once
    if ($authId !== null) {
        HistoryLogHelper::log(
            $authId,
            $validated['fair_code'],
            $validated['user_id'],
            'delete',
            $description
        );
    }

    return response()->json([
        'success' => true,
        'message' => 'All discount items deleted successfully.',
        'deleted' => $discountCount,
    ], 200);
}

    //! End Discounts

    public function purchaser_create(Request $request)
    {
        return view('admin.registration.buyer.create');
    }

    public function purchaser_store(Request $request)
    {
        $company_info = json_decode($request->input('company_info'), true);
        $purchaser_profile = json_decode($request->input('buyer_profile'), true);
        $participation_info = json_decode($request->input('participation_info'), true);

        $status = $request->input('set_to_pending');

        $user = new User;
        $user->name = Str::upper($company_info['co_name']);
        $user->email = Str::of($company_info['email'])->lower();
        $user->password = NULL;
        $user->user_group = 3;
        $user->data_from = 'backend';
        if ($status) {
            $user->status = 2;
        }
        $user->save();

        $user->buyer()->create([
            'country' => $company_info['country'],
            'co_name' => Str::upper($company_info['co_name']),
            'slug' => Str::of($company_info['co_name'])->slug('-'),
            'co_email' => Str::lower($company_info['co_email']),
            'state' => $company_info['fa_state'],
            'city' => $company_info['fa_city'],
            'zipcode' => $company_info['fa_zipcode'],
            'region' => $company_info['fa_region'],
            'street' => $company_info['fa_street'],
            'country_code' => $company_info['country_code'],
            'area_code' => $company_info['area_code'],
            'phone_no' => $company_info['phone_no'],
            'website' => $company_info['website'],
            'year_established' => $company_info['year_estab'],
            'facebook' => $company_info['facebook'],
            'instagram' => $company_info['instagram'],
            'linkedin' => $company_info['linkedin'],
            'other_social' => $company_info['other_social'],
            'organization_type_id' => $company_info['organization_type'],
            'honorific' => $company_info['honorific'],
            'fname' => Str::title($company_info['fname']),
            'lname' => Str::title($company_info['lname']),
            'mi' => Str::upper($company_info['mi']),
            'email' => Str::of($company_info['email'])->lower(),
            'designation' => Str::title($company_info['designation']),
            'company_role_id' => $company_info['role'],
            'interested_meeting' => $participation_info['interested'],
            'need_interpreter' => ($participation_info['interested'] == 1) ? $participation_info['if_yes'] : NULL,
            'last_update_by' => Auth::id()
        ]);

        //NATURE BUSINESS
        if (!empty($user->nature_business)) {
            $user->nature_business()->delete();
        }
        $arr_nature_business = [];
        foreach ($company_info['nature_business'] as $nb) {
            $nature_business = NatureBusiness::find($nb);
            if (!empty($nature_business)) {
                $arr_nature_business[] = [
                    'nature_business_id' => $nature_business->id,
                    'remarks' => $nature_business->name
                ];
            }
        }
        $user->nature_business()->createMany($arr_nature_business);

        //Categories & Sub-Categories
        if (!empty($user->category_subcategory)) {
            $user->category_subcategory()->delete();
        }
        $arr_categories = [];
        foreach ($purchaser_profile['categories'] as $sub) {
            $sub_category = SubCategory::find($sub);
            if (!empty($sub_category)) {
                $arr_categories[] = [
                    'category_id' => $sub_category->category_id,
                    'category_remarks' => $sub_category->category->name,
                    'sub_category_id' => $sub_category->id,
                    'sub_category_remarks' => $sub_category->name
                ];
            }
        }
        $user->category_subcategory()->createMany($arr_categories);

        //PARTICIPATION GOALS
        if (!empty($user->participation_goal)) {
            $user->participation_goal()->delete();
        }
        $arr_participation_goal = [];
        foreach ($participation_info['participation_goals'] as $goal) {
            $participation_goal = ParticipationGoal::find($goal);
            if (!empty($participation_goal)) {
                if ($participation_goal->id === 11) {
                    $remarks = Str::title($participation_info['participation_goal_others']);
                } else {
                    $remarks = $participation_goal->name;
                }
                $arr_participation_goal[] = [
                    'participation_id' => $participation_goal->id,
                    'remarks' => $remarks
                ];
            }
        }
        $user->participation_goal()->createMany($arr_participation_goal);

        //HOW DID YOU LEARN ABOUT THE EVENT
        if (!empty($user->learn_about_event)) {
            $user->learn_about_event()->delete();
        }
        $arr_learn_about_event = [];
        foreach ($participation_info['about_events'] as $event) {
            $about_event = AboutEvent::find($event);
            if (!empty($about_event)) {
                if ($about_event->id === 9) {
                    $remarks = Str::title($participation_info['about_event_others']);
                } else {
                    $remarks = $about_event->name;
                }
                $arr_learn_about_event[] = [
                    'learn_about_event_id' => $about_event->id,
                    'remarks' => $remarks
                ];
            }
        }
        $user->learn_about_event()->createMany($arr_learn_about_event);

        // if (env('SSX_API_SYNC')) {
        //     $this->citemAPICreate($user->id);
        // }

        return response()->json(true, 200);
    }





public function purchaser_update(Request $request)
{
    $user_id = $request->input('user_id');
    $fair_code = $request->input('fair_code');

    $user = User::findOrFail($user_id);

    $flagFields = ['buyerclass']; 

foreach ($flagFields as $field) {
    $user->$field = ($request->input($field));
}

$user->save();

    $is_pending = $request->input('to_pending');
    // If user is set to pending
if ((int) $is_pending === 1) {
    BuyerAttendance::updateOrCreate(
        [
            'user_id'   => $user->id,
            'fair_code' => $fair_code,
        ],
        ['status' => 2]
    );
    $this->touchBuyer($user, $fair_code);
}


    // Update user's display name
    $user->name = Str::upper($request->input('co_name'));
    $user->save();

    // Decode JSON payloads
    $company_info = json_decode($request->input('company_info'), true);
    $buyer_profile = json_decode($request->input('buyer_profile'), true);
    $participation_info = json_decode($request->input('participation_info'), true);

    // Fetch or create buyer for this fair
    $buyer = $user->buyerForFair($fair_code) ?? $user->buyer()->create(['fair_code' => $fair_code]);
     $this->touchBuyer($user, $fair_code);
    // Update buyer main info
    $buyer->update([
        'country'             => $company_info['country'] ?? null,
        'co_name'             => Str::upper($company_info['co_name'] ?? ''),
        'co_email'            => Str::lower($company_info['co_email'] ?? ''),
        'state'               => $company_info['fa_state'] ?? null,
        'city'                => $company_info['fa_city'] ?? null,
        'zipcode'             => $company_info['fa_zipcode'] ?? null,
        'region'              => $company_info['fa_region'] ?? null,
        'street'              => $company_info['fa_street'] ?? null,
        'country_code'        => $company_info['country_code'] ?? null,
        'area_code'           => $company_info['area_code'] ?? null,
        'phone_no'            => $company_info['phone_no'] ?? null,
        'website'             => $company_info['website'] ?? null,
        'year_established'    => $company_info['year_estab'] ?? null,
        'facebook'            => $company_info['facebook'] ?? null,
        'instagram'           => $company_info['instagram'] ?? null,
        'linkedin'            => $company_info['linkedin'] ?? null,
        'other_social'        => $company_info['other_social'] ?? null,
        'organization_type_id'=> $company_info['organization_type'] ?? null,
        'honorific'           => $company_info['honorific'] ?? null,
        'fname'               => Str::title($company_info['fname'] ?? ''),
        'lname'               => Str::title($company_info['lname'] ?? ''),
        'mi'                  => Str::upper($company_info['mi'] ?? ''),
        'designation'         => Str::title($company_info['designation'] ?? ''),
        'company_role_id'     => $company_info['role'] ?? null,
        'company_annual_sale_id'     => $company_info['company_annual_sale'] ?? null,
        'annual_purchase_from_existing_supplier_id' => $company_info['annual_purchase_existing_supplier'],
        'has_ph_business_supplier' => $company_info['has_ph_business_supplier'],
        'ph_supplier_name' => $company_info['ph_supplier_name'],
        'interested_meeting'  => $participation_info['interested'] ?? null,
        'last_update_by'      => Auth::id(),
    ]);

    //   'need_interpreter'    => ($participation_info['interested'] ?? 0) == 1
    //                              ? $participation_info['if_yes'] ?? null
    //                              : null,

 /*
|--------------------------------------------------------------------------
| NATURE OF BUSINESS (per fair)
|--------------------------------------------------------------------------
*/
    $user->nature_business()->where('fair_code', $fair_code)->delete();
    $arr_nature_business = [];
    foreach ($company_info['nature_business'] ?? [] as $nb) {
        $nature_business = NatureBusiness::find($nb);
        if ($nature_business) {
             $remarks = ($nature_business->id === 16)
                ? Str::title($company_info['nature_business_other'])
                : $nature_business->name;

            $arr_nature_business[] = [
                'nature_business_id' => $nature_business->id,
                'remarks' =>    $remarks,
                'fair_code' => $fair_code
            ];
        }
    }
    $user->nature_business()->createMany($arr_nature_business);

    /*
    |----------------------------------------------------------------------
    | CATEGORIES (per fair)
    |----------------------------------------------------------------------
    */
    $user->category_subcategory()->where('fair_code', $fair_code)->delete();
    $arr_categories = [];
    foreach ($buyer_profile['categories'] ?? [] as $sub) {
        $sub_category = SubCategory::find($sub);
        if ($sub_category) {
            $arr_categories[] = [
                'category_id'           => $sub_category->category_id,
                'category_remarks'      => $sub_category->category->name,
                'sub_category_id'       => $sub_category->id,
                'sub_category_remarks'  => $sub_category->name,
                'fair_code'             => $fair_code
            ];
        }
    }
    if (!empty($arr_categories)) {
        $user->category_subcategory()->createMany($arr_categories);
    }

    /*
    |----------------------------------------------------------------------
    | PARTICIPATION GOALS (per fair)
    |----------------------------------------------------------------------
    */
    $user->participation_goal()->where('fair_code', $fair_code)->delete();
    $arr_participation_goal = [];
    foreach ($participation_info['participation_goals'] ?? [] as $goal) {
        $pg = ParticipationGoal::find($goal);
        if ($pg) {
            $remarks = ($pg->id === 11)
                ? Str::title($participation_info['participation_goal_others'] ?? '')
                : $pg->name;

            $arr_participation_goal[] = [
                'participation_id' => $pg->id,
                'remarks'          => $remarks,
                'fair_code'        => $fair_code
            ];
        }
    }
    if (!empty($arr_participation_goal)) {
        $user->participation_goal()->createMany($arr_participation_goal);
    }

    /*
    |----------------------------------------------------------------------
    | LEARN ABOUT EVENT (per fair)
    |----------------------------------------------------------------------
    */
    $user->learn_about_event()->where('fair_code', $fair_code)->delete();
    $arr_learn = [];
    foreach ($participation_info['about_events'] ?? [] as $ev) {
        $about = AboutEvent::find($ev);
        if ($about) {
            $remarks = ($about->id === 9)
                ? Str::title($participation_info['about_event_others'] ?? '')
                : $about->name;

            $arr_learn[] = [
                'learn_about_event_id' => $about->id,
                'remarks'              => $remarks,
                'fair_code'            => $fair_code
            ];
        }
    }
    if (!empty($arr_learn)) {
        $user->learn_about_event()->createMany($arr_learn);
    }

    /*
    |----------------------------------------------------------------------
    | API SYNC
    |----------------------------------------------------------------------
    */
    // if (env('SSX_API_SYNC')) {
    //     $this->citemAPIUpdateBuyer($user->id);
    // }
$this->touchBuyer($user, $fair_code);
    return response()->json(true, 200);
}




}
