<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Models\Exhibitor;
use App\Models\ExhibitorDocument;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Supplier\Event;
use App\Models\Supplier\ParticipationAddOnRates;
use App\Models\Supplier\ParticipationAddOnSelection;
use App\Models\Supplier\PitchingSessionCategoriesSelections;
use App\Models\Supplier\ParticipationBoothSelection;
use App\Models\Supplier\ParticipationBoothSizes;
use App\Models\Supplier\ParticipationMandatory;
use App\Models\Supplier\ParticipationPackages;
use App\Models\Supplier\ParticipationSpaces;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\PitchingSessionCategories;
use App\Mail\ExhbitorRegistrationSuccess;
use App\Mail\SupplierRegistrationSuccess;
use App\Models\User;
use App\Models\HistoricalLog;
use App\Models\UserAgreement;
use App\Models\NatureBusiness;
use App\Models\Supplier\AdditionalFees;
use App\Models\Supplier\Discounts;
use App\Models\Supplier\Topic;
use App\Models\TargetBuyer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Helpers\HistoryLogHelper;

class ApiController extends Controller
{
    protected $discountStart;
    protected $discountEnd;
    protected $discountRate;
    protected $discountRemark;

    public function __construct()
    {
        // Early-bird discount period: Sep 1 2025 - Dec 31 2025
        $this->discountStart  = Carbon::create(2025, 9, 1, 0, 0, 0);
        // $this->discountEnd = Carbon::create(2025, 12, 31, 23, 59, 59);
        $this->discountEnd = Carbon::create(2025, 12, 31, 23, 59, 59);
        $this->discountRate   = 0.95; 
        $this->discountRemark = '5% Early Bird';
    }


    //     private function calculateParticipationAmount($space, $size)
    // {
    //     return $space->cost_per_sqm * ($size->code_promo ?? $size->code);
    // }


    private function calculateParticipationAmount($space, $qty, $size, $startUp = false)
    {
        if ($startUp) {
            return $space->cost_per_sqm * $qty;
        }

        $sqm = $size->code_promo ?? $size->code;

        return $space->cost_per_sqm * $sqm * $qty;
    }



    protected function applyDiscount($amount)
    {
        $now = Carbon::now();

        if ($now->between($this->discountStart, $this->discountEnd)) {
            $discountAmount = $amount * (1 - $this->discountRate);
            $totalDue = $amount - $discountAmount;
            return [
                'discount' => $discountAmount,
                'discount_remarks' => $this->discountRemark,
                'total_amount_due' => $totalDue,
            ];
        }

        // No discount
        return [
            'discount' => 0,
            'discount_remarks' => null,
            'total_amount_due' => $amount,
        ];
    }



    private function deleteAllPitchingSelections(int $user_id, string $fair_code)
        {
    
        // Delete all PitchingSessionCategoriesSelections for this user + fair
        PitchingSessionCategoriesSelections::where('ff_code', $user_id)
            ->where('fair_code', $fair_code)
            ->delete();
        }




//     { 
//         $addOnRates = ParticipationAddOnRates::with('addOn') ->where('business_type_id', $business_type_id) ->whereHas('addOn', function($q) use ($fair_code) { $q->where('fair_code', $fair_code); }) ->get() ->filter(function ($rate) use ($fair_code) { $addOn = $rate->addOn; if (!$addOn) { return false; } 
//     // Fetch total quantity already selected for this add-on in the same fair 
//     $totalQty = ParticipationAddOnSelection::where('participation_addon_id', $addOn->id) ->where('fair_code', $fair_code) ->sum('qty'); 
//     // If limit_overall is set and totalQty has reached/exceeded it — exclude 
//     if (!is_null($addOn->limit_overall) && $totalQty >= $addOn->limit_overall) { return false;  // skip this item 
//         } return true; 
//         // include this rate 
//         }); 
//         $result = $addOnRates->map(function($rate) { 
//             return [ 
//                 'id' => $rate->id, 'currency' => $rate->currency, 'cost' => $rate->cost, 'status' => $rate->status, 'add_on' => [ 
//                     'id' => $rate->addOn->id, 'name' => $rate->addOn->name ?? null, 'unit' => $rate->addOn->unit ?? null, 'notes' => $rate->addOn->notes ?? null, 'limit_overall' => $rate->addOn->limit_overall ?? null, 'limit_per_exhibitor' => $rate->addOn->limit_per_exhibitor ?? null, 
//                     'status' => $rate->addOn->status ?? null, 
//                 ], 
//             ]; 
//         }); 
//         return response()->json([ 'success' => true, 'add_on_rates' => $result->values(), 
//     ]); 
// }

   
protected function pitchingCompetition($rate)
    {
        return $rate->addOn && $rate->addOn->id == 5;
    }

    protected function pitchingCompetitionCost($rate)
{
    if ($this->pitchingCompetition($rate)) {
        return null; // no cost
    }

    return $rate->cost;
}

private function logHistory($actorUserId, $fairCode, $target_ff_code, $process, $description)
{
    HistoricalLog::create([
        'ff_code'   => $actorUserId,
        'fair_code' => $fairCode,
        'target_ff_code' => $target_ff_code,
        'process'   => $process,   // add | delete
        'old_data'  => $description,
    ]);
}

private function updateExistingCartItem(
    Exhibitor $exhibitor,
    string $fair_code,
    ParticipationPackages $package,
    ParticipationSpaces $space,
    ParticipationBoothSizes $size,
    int $booth_qty,
    int $participation_type
) {
    $existingSelection = ParticipationBoothSelection::where('ff_code', $exhibitor->uid)
        ->where('fair_code', $fair_code)
        ->where('package_id', $package->id)
        ->where('space_id', $space->id)
        ->where('booth_size_code', $size->id)
        ->first();

    if (!$existingSelection) {
        return null;
    }

    // 🔒 Individual = always 1
    if ($participation_type === 1) {
        $booth_qty = 1;
    } 

    // 💰 Recalculate pricing
    if ($size->code_promo) {
        $sqmNormal = $size->code;
        $sqmPromo  = $size->code_promo;

        $normalAmount = $space->cost_per_sqm * $sqmNormal * $booth_qty;
        $promoAmount  = $space->cost_per_sqm * $sqmPromo  * $booth_qty;

        $participationAmount = $normalAmount;

        $discountData = [
            'discount'         => $normalAmount - $promoAmount,
            'discount_remarks' => '9+1 promo',
            'total_amount_due' => $promoAmount,
        ];
    } else {
         $participationAmount = $this->calculateParticipationAmount(
            $space, 
            $booth_qty, 
            $size, 
            $request->start_up ?? false);
        $discountData = $this->applyDiscount($participationAmount);
    }

    $existingSelection->update([
        'booth_qty'           => $booth_qty,
        'total_participation' => $participationAmount,
        'sub_total'           => $participationAmount,
        'discount'            => $discountData['discount'],
        'discount_remarks'    => $discountData['discount_remarks'],
        'total_amount_due'    => $discountData['total_amount_due'],
    ]);

    return $existingSelection;
}



 public function fetchAddOnRatesByBusinessTypeAndFair($business_type_id, $fair_code)
    {
    $addOnRates = ParticipationAddOnRates::with('addOn')
        ->where('business_type_id', $business_type_id)
        ->whereHas('addOn', function ($q) use ($fair_code) {
            $q->where('fair_code', $fair_code);
        })
        ->get()
        ->filter(function ($rate) use ($fair_code) {

            $addOn = $rate->addOn;
            if (!$addOn) {
                return false;
            }

            // ✅ Pitching Competition (ID = 5): ignore overall limit
            if ($addOn->id == 5) {
                return true;
            }

            // Fetch total quantity already selected for this add-on in the same fair
            $totalQty = ParticipationAddOnSelection::where(
                'participation_addon_id',
                $addOn->id
            )
            ->where('fair_code', $fair_code)
            ->sum('qty');

            // Exclude if overall limit reached
            if (!is_null($addOn->limit_overall) && $totalQty >= $addOn->limit_overall) {
                return false;
            }

            return true;
        });

    $result = $addOnRates->map(function ($rate) use ($fair_code) {

        $addOn = $rate->addOn;

        $data = [
            'id'       => $rate->id,
            'currency' => $rate->currency,
            'cost'     => $this->pitchingCompetitionCost($rate),
            'status'   => $rate->status,
            'add_on'   => [
                'id'                  => $addOn->id,
                'name'                => $addOn->name ?? null,
                'unit'                => $addOn->unit ?? null,
                'notes'               => $addOn->notes ?? null,
                'limit_overall'       => $addOn->limit_overall ?? null,
                'limit_per_exhibitor' => $addOn->limit_per_exhibitor ?? null,
                'status'              => $addOn->status ?? null,
            ],
        ];

        // ✅ Attach pitching session categories ONLY for ID = 5
        if ($addOn->id == 5) {
            $data['pitching_session_categories'] =
                PitchingSessionCategories::where(
                    'participation_addon_id',
                    $addOn->id
                )
                ->where('fair_code', $fair_code)
                ->get(['id', 'value']);
        }

        return $data;
    });

    return response()->json([
        'success' => true,
        'add_on_rates' => $result->values(),
    ]);
}
    
public function pick_topics()
{
    $results = Topic::orderBy('id', 'asc')->get();
    return response()->json($results, 200);
}
    
public function getSpecificEvent($id)
{
    $event = Event::findOrFail($id);
    return response()->json($event);
}


// public function getPackages(Request $request){
//     $userId = $request->input('user_id');
//     $user = User::find($userId);

//     if (!$user) {
//         return response()->json(['message' => 'No user found'], 404);
//     }

//     $isStartup = $request->boolean('is_startup', false); // defaults to false
//     $businessType = $request->input('business_type'); //  
//     // Get all packages with active sizes and spaces filtered by type
//     $packages = ParticipationPackages::with([
//        'participation_booth_sizes' => function ($query) {
//     $query->where('status', 1)
//           ->orderBy('code', 'asc');
// },
//         'participation_booth_spaces' => function ($query) use ($isStartup, $businessType) {
//             $type = $isStartup ? 'startup' : 'default';
//             $query->where('type', $type);

//             // Filter by business_type
//             if ($businessType) {
//                 $query->where('business_type_id', $businessType);
//             }
//         }
//     ])->get();

//     foreach ($packages as $package) {
//         $activeSizes = $package->participation_booth_sizes;

//         // Attach filtered sizes to each space
//         foreach ($package->participation_booth_spaces as $space) {
//             $spaceFilteredSizes = [];
//             foreach ($activeSizes as $size) {
//                 $sizeCode = (int) $size->code;
//                 if ($sizeCode >= (int) $space->booth_min_size && $sizeCode <= (int) $space->booth_max_size) {
//                     $spaceFilteredSizes[] = $size;
//                 }
//             }
//             $space->filtered_sizes = collect($spaceFilteredSizes);
//         }

//         // Filter package sizes globally to only those that fit at least one space
//         $filteredAllSizes = [];
//         foreach ($activeSizes as $size) {
//             $fitsSomeSpace = false;
//             $sizeCode = (int) $size->code;
//             foreach ($package->participation_booth_spaces as $space) {
//                 if ($sizeCode >= (int) $space->booth_min_size && $sizeCode <= (int) $space->booth_max_size) {
//                     $fitsSomeSpace = true;
//                     break;
//                 }
//             }
//             if ($fitsSomeSpace) {
//                 $filteredAllSizes[] = $size;
//             }
//         }

//         $package->participation_booth_sizes = collect($filteredAllSizes);
//     }

//     return response()->json($packages);
// }


public function getPackages(Request $request)
{
    $userId = $request->input('user_id');
    $user = User::find($userId);

    if (!$user) {
        return response()->json([
            'message' => 'No user found'
        ], 404);
    }

    $isStartup = $request->boolean('is_startup', false);
    $businessType = $request->input('business_type');

    // NEW
    $participationType = (int) $request->input(
        'participation_type'
    );

    // Get all packages with active sizes and spaces filtered by type
    $packages = ParticipationPackages::with([

        'participation_booth_sizes' => function ($query) {
            $query->where('status', 1)
                ->orderBy('code', 'asc');
        },

        'participation_booth_spaces' => function ($query) use (
            $isStartup,
            $participationType,
            $businessType
        ) {

            /*
            |--------------------------------------------------------------------------
            | SPACE TYPE
            |--------------------------------------------------------------------------
            */

            if ($isStartup) {

                // Startup checkbox checked
                $query->where('type', 'startup');

            } elseif ($participationType === 2) {

                // Group participation
                // Startup checkbox NOT checked
                // Show BOTH
                $query->whereIn('type', [
                    'default',
                    'startup'
                ]);

            } else {

                // Individual participation
                // Startup checkbox NOT checked
                // Show DEFAULT only
                $query->where(
                    'type',
                    'default'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | BUSINESS TYPE
            |--------------------------------------------------------------------------
            */

            if ($businessType) {
                $query->where(
                    'business_type_id',
                    $businessType
                );
            }
        }

    ])->get();

    foreach ($packages as $package) {

        $activeSizes =
            $package->participation_booth_sizes;

        /*
        |--------------------------------------------------------------------------
        | ATTACH FILTERED SIZES TO EACH SPACE
        |--------------------------------------------------------------------------
        */

        foreach (
            $package->participation_booth_spaces
            as $space
        ) {

            $spaceFilteredSizes = [];

            foreach ($activeSizes as $size) {

                $sizeCode = (int) $size->code;

                if (
                    $sizeCode >=
                        (int) $space->booth_min_size
                    &&
                    $sizeCode <=
                        (int) $space->booth_max_size
                ) {

                    $spaceFilteredSizes[] =
                        $size;
                }
            }

            $space->filtered_sizes =
                collect($spaceFilteredSizes);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PACKAGE SIZES GLOBALLY
        |--------------------------------------------------------------------------
        */

        $filteredAllSizes = [];

        foreach ($activeSizes as $size) {

            $fitsSomeSpace = false;

            $sizeCode = (int) $size->code;

            foreach (
                $package->participation_booth_spaces
                as $space
            ) {

                if (
                    $sizeCode >=
                        (int) $space->booth_min_size
                    &&
                    $sizeCode <=
                        (int) $space->booth_max_size
                ) {

                    $fitsSomeSpace = true;
                    break;
                }
            }

            if ($fitsSomeSpace) {
                $filteredAllSizes[] =
                    $size;
            }
        }

        $package->participation_booth_sizes =
            collect($filteredAllSizes);
    }

    return response()->json($packages);
}

public function fetch_additional_fees(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    // Fetch user
    $user = User::find($validated['ff_code']);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Check exhibitor for this fair
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Fetch additional fees
    $fees = AdditionalFees::where('ff_code', $validated['ff_code'])
        ->where('fair_code', $validated['fair_code'])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success'   => true,
        'message'   => 'Additional fees fetched successfully.',
        'ff_code'   => $validated['ff_code'],
        'fair_code' => $validated['fair_code'],
        'fees'      => $fees,
    ], 200);
}


public function fetch_discounts(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'ff_code'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    // Fetch user
    $user = User::find($validated['ff_code']);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Check exhibitor for this fair
    $exhibitor = $user->exhibitorForFair($validated['fair_code']);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Discounts
    $discounts = Discounts::where('ff_code', $validated['ff_code'])
        ->where('fair_code', $validated['fair_code'])
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success'   => true,
        'message'   => 'Discounts fetched successfully.',
        'ff_code'   => $validated['ff_code'],
        'fair_code' => $validated['fair_code'],
        'discounts'      => $discounts,
    ], 200);
}






// public function check_cart_booth_sizes(Request $request)
// {
//     $cart = $request->input('cart', []);
//     $invalidItems = [];
//     $reason = '';

//     // Only 1 item allowed
//     if (count($cart) !== 1) {
//         $invalidItems = array_column($cart, 'id');
//         $reason = 'only_one';
//         return response()->json([
//             'success' => true,
//             'invalid_items' => $invalidItems,
//             'has_invalid' => true,
//             'reason' => $reason,
//             'message' => 'Only one booth can be selected for individual participation.'
//         ]);
//     }

//     $item = $cart[0];

//     // Lookup booth size
//     $record = ParticipationBoothSizes::find($item['booth_size_code']);
    
//     // Invalid if record not found, status = 0, code < 4 or > 8, or code = 8 (optional if you want to restrict)
//     if (!$record || $record->status == 0 || $record->code < 4 || $record->code > 8) {
//         $invalidItems[] = $item['id'];
//         $reason = 'invalid_size';
//         return response()->json([
//             'success' => true,
//             'invalid_items' => $invalidItems,
//             'has_invalid' => true,
//             'reason' => $reason,
//             'message' => 'Selected booth size is not valid.'
//         ]);
//     }

//     // Check quantity – individual participation must be 1
//     $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
//     if ($qty !== 1) {
//         $invalidItems[] = $item['id'];
//         $reason = 'invalid_quantity';
//         return response()->json([
//             'success' => true,
//             'invalid_items' => $invalidItems,
//             'has_invalid' => true,
//             'reason' => $reason,
//             'message' => 'Only a quantity of 1 is allowed for individual participation.'
//         ]);
//     }

//     // All checks passed
//     return response()->json([
//         'success' => true,
//         'invalid_items' => [],
//         'has_invalid' => false,
//         'reason' => '',
//         'message' => 'Booth selection is valid.'
//     ]);
// }



public function check_cart_booth_sizes(Request $request)
{
    $cart = $request->input('cart', []);
    $invalidItems = [];
    $reason = '';

    // Only 1 item allowed
    // if (count($cart) !== 1) {
    //     $invalidItems = array_column($cart, 'id');
    //     $reason = 'only_one';
    //     return response()->json([
    //         'success' => true,
    //         'invalid_items' => $invalidItems,
    //         'has_invalid' => true,
    //         'reason' => $reason,
    //         'message' => 'Only one booth can be selected for individual participation.'
    //     ]);
    // }

    $item = $cart[0];

    // Lookup booth size
    $record = ParticipationBoothSizes::find($item['booth_size_code']);
    
    // Invalid if record not found, status = 0, code < 4 or > 8, or code = 8 (optional if you want to restrict)
    if (!$record || $record->status == 0 || $record->code < 4 || $record->code > 8) {
        $invalidItems[] = $item['id'];
        $reason = 'invalid_size';
        return response()->json([
            'success' => true,
            'invalid_items' => $invalidItems,
            'has_invalid' => true,
            'reason' => $reason,
            'message' => 'Selected booth size is not valid.'
        ]);
    }

    // Check quantity – individual participation must be 1
    $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
    if ($qty !== 1) {
        $invalidItems[] = $item['id'];
        $reason = 'invalid_quantity';
        return response()->json([
            'success' => true,
            'invalid_items' => $invalidItems,
            'has_invalid' => true,
            'reason' => $reason,
            'message' => 'Only a quantity of 1 is allowed for individual participation.'
        ]);
    }

    // All checks passed
    return response()->json([
        'success' => true,
        'invalid_items' => [],
        'has_invalid' => false,
        'reason' => '',
        'message' => 'Booth selection is valid.'
    ]);
}


// public function check_group_cart_booth_sizes(Request $request)
// {
//     $cart = $request->input('cart', []);
//     $invalidItems = [];

//     if (empty($cart)) {
//         return response()->json([
//             'success' => true,
//             'invalid_items' => [],
//             'has_invalid' => true,
//             'message' => 'Cart is empty'
//         ]);
//     }

//     $totalCode = 0;

//     foreach ($cart as $item) {
//         // Lookup by code (or primary key if needed)
//         $record = ParticipationBoothSizes::find($item['booth_size_code']);

//         if (!$record) {
//             // If the record doesn't exist, consider the item invalid
//             $invalidItems[] = $item['id'];
//         } else {
//             // Sum the code values
//             $totalCode += $record->code;
//         }
//     }

//     // Check if total code reaches minimum for group participation
//     if ($totalCode < 16) {
//         // If total < 16, all items are invalid
//         $invalidItems = array_column($cart, 'id');
//     }

//     return response()->json([
//         'success' => true,
//         'invalid_items' => $invalidItems,
//         'has_invalid' => !empty($invalidItems),
//         'total_code' => $totalCode
//     ]);
// }



public function check_group_cart_booth_sizes(Request $request)
{
    $cart = $request->input('cart', []);
    $invalidItems = [];
    $reason = '';

    if (empty($cart)) {
        return response()->json([
            'success' => true,
            'invalid_items' => [],
            'has_invalid' => true,
            'reason' => 'empty_cart',
            'message' => 'Cart is empty'
        ]);
    }

    foreach ($cart as $item) {
        $record = ParticipationBoothSizes::find($item['booth_size_code']);

        // Invalid if record not found OR status = 0 OR code = 8
        if (!$record || $record->status == 0 || $record->code == 8) {
            $invalidItems[] = $item['id'];
            $reason = 'invalid_size';
            continue;
        }
    }

    return response()->json([
        'success' => true,
        'invalid_items' => $invalidItems,
        'has_invalid' => !empty($invalidItems),
        'reason' => $reason
    ]);
}


public function fetch_cart($user_id, $fair_code)
{
    // Fetch user
    $user = User::find($user_id);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }
    

    // Get exhibitor for this fair
    $exhibitor = $user->exhibitorForFair($fair_code);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 404);
    }

    // Fetch cart items for this exhibitor and fair
    $cart = Exhibitor::where('uid', $exhibitor->uid)
        ->with([
            'participationSelections' => function ($query) use ($fair_code) {
                $query->where('fair_code', $fair_code);
            },
            'participationSelections.package:id,title,sub_title,booth_details',
            'participationSelections.space:id,name',
            'participationSelections.size:id,name',
        ])
        ->first();

    // Safely get participation selections
    $selections = collect();
    if ($cart && $cart->participationSelections) {
        $selections = $cart->participationSelections;
    }

    // If no selections, return empty cart
    if ($selections->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No cart items found for this exhibitor.',
            'cart'    => [],
        ], 200);
    }

    // Success
    return response()->json([
        'success'   => true,
        'message'   => 'Cart fetched successfully.',
        'user_id'   => $user_id,
        'fair_code' => $fair_code,
        'cart'      => $cart,
    ], 200);
}



public function add_to_cart(Request $request)
{
    $validated = $request->validate([
        'package_id' => 'required|integer|exists:participation_packages,id',
        'space_id' => 'required|integer|exists:participation_spaces,id',
        'size_id' => 'required|integer|exists:participation_booth_sizes,id',
        'qty' => 'nullable|integer',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
        'start_up' => 'nullable|boolean',
        'participation_type' => 'required|integer',

        // Selected booth space type
        'space_type' => 'required|string|in:default,startup',
    ]);

    $fair_code = $validated['fair_code'];

    $user = User::findOrFail($request->user_id);

    $authUser = Auth::guard('web')->user()
        ?: Auth::guard('supplier')->user();

    $addedBy = $authUser ? $authUser->id : null;

    $exhibitor = $user->exhibitorForFair($fair_code);

    if (!$exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor record not found for this fair.',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | GET PACKAGE / SPACE / SIZE
    |--------------------------------------------------------------------------
    */

    $package = ParticipationPackages::findOrFail(
        $validated['package_id']
    );

    $space = ParticipationSpaces::findOrFail(
        $validated['space_id']
    );

    $size = ParticipationBoothSizes::findOrFail(
        $validated['size_id']
    );

    $booth_qty = (int) ($validated['qty'] ?? 1);

    if ($booth_qty < 1) {
        $booth_qty = 1;
    }

    $boothPackage = $package->title;
    $boothSizeName = $size->name;
    $boothAmount = $space->cost_per_sqm;
    $currency = $space->currency;


    /*
    |--------------------------------------------------------------------------
    | START-UP CHECKBOX RESTRICTION
    |--------------------------------------------------------------------------
    |
    | Keep the existing startup restriction.
    |
    | BUT:
    | If the existing cart item is the SAME package + SAME space,
    | allow it to update the quantity.
    |
    */

    if ($validated['start_up']) {

        $existingSpace = ParticipationBoothSelection::where(
            'ff_code',
            $exhibitor->uid
        )
        ->where('fair_code', $fair_code)
        ->first();

        if ($existingSpace) {

            $sameSpace =
                $existingSpace->package_id == $package->id &&
                $existingSpace->space_id == $space->id;

            if (!$sameSpace) {
                return response()->json([
                    'success' => false,
                    'message' => 'Start-up purchasers/exhibitors can only select one booth space.',
                ], 200);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | STARTUP SPACE
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    |
    | This is based on space_type.
    |
    | It does NOT depend on the startup checkbox.
    |
    | startup:
    |
    | cost_per_sqm × qty
    |
    | Example:
    |
    | ₱8,000 × 1 = ₱8,000
    | ₱8,000 × 2 = ₱16,000
    | ₱8,000 × 3 = ₱24,000
    |
    */

    if ($validated['space_type'] === 'startup') {

        /*
        |--------------------------------------------------------------------------
        | FIND EXISTING STARTUP ITEM
        |--------------------------------------------------------------------------
        */

        $existingItem = ParticipationBoothSelection::where(
            'ff_code',
            $exhibitor->uid
        )
        ->where('fair_code', $fair_code)
        ->where('package_id', $package->id)
        ->where('space_id', $space->id)
        ->first();


        /*
        |--------------------------------------------------------------------------
        | UPDATE EXISTING STARTUP ITEM
        |--------------------------------------------------------------------------
        */

        if ($existingItem) {

            $participationAmount =
                $space->cost_per_sqm * $booth_qty;

            $discountData = $this->applyDiscount(
                $participationAmount
            );

            $existingItem->booth_qty =
                $booth_qty;

            $existingItem->total_participation =
                $participationAmount;

            $existingItem->sub_total =
                $participationAmount;

            $existingItem->discount =
                $discountData['discount'];

            $existingItem->discount_remarks =
                $discountData['discount_remarks'];

            $existingItem->total_amount_due =
                $discountData['total_amount_due'];

            $existingItem->booth_amount =
                $boothAmount;

            $existingItem->currency =
                $currency;

            $existingItem->save();


            /*
            |--------------------------------------------------------------------------
            | FETCH UPDATED CART
            |--------------------------------------------------------------------------
            */

            $cart = Exhibitor::where(
                'uid',
                $exhibitor->uid
            )
            ->with([
                'participationSelections' => function ($query) use ($fair_code) {
                    $query->where(
                        'fair_code',
                        $fair_code
                    );
                },

                'participationSelections.package:id,title,sub_title',

                'participationSelections.space:id,name,type',

                'participationSelections.size:id,name',
            ])
            ->first();


            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully.',
                'cart' => $cart,
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE NEW STARTUP ITEM
        |--------------------------------------------------------------------------
        */

        $participationAmount =
            $space->cost_per_sqm * $booth_qty;

        $discountData = $this->applyDiscount(
            $participationAmount
        );

        $cartItem = [
            'package_id' =>
                $package->id,

            'space_id' =>
                $space->id,

            'booth_size_code' =>
                $size->id,

            'booth_size_name' =>
                $boothSizeName,

            'booth_package' =>
                $boothPackage,

            'booth_qty' =>
                $booth_qty,

            'total_participation' =>
                $participationAmount,

            'sub_total' =>
                $participationAmount,

            'discount' =>
                $discountData['discount'],

            'discount_remarks' =>
                $discountData['discount_remarks'],

            'total_amount_due' =>
                $discountData['total_amount_due'],

            'booth_amount' =>
                $boothAmount,

            'currency' =>
                $currency,

            'ff_code' =>
                $exhibitor->uid,

            'fair_code' =>
                $fair_code,

            'status' =>
                0,

            'added_by' =>
                $addedBy,
        ];

    } else {

        /*
        |--------------------------------------------------------------------------
        | DEFAULT SPACE
        |--------------------------------------------------------------------------
        |
        | KEEP LEGACY LOGIC
        |--------------------------------------------------------------------------
        */

        if ($size->code_promo) {

            $sqmNormal = $size->code;
            $sqmPromo = $size->code_promo;

            $normalAmount =
                $space->cost_per_sqm
                * $sqmNormal
                * $booth_qty;

            $promoAmount =
                $space->cost_per_sqm
                * $sqmPromo
                * $booth_qty;

            $participationAmount =
                $normalAmount;

            $discountData = [
                'discount' =>
                    $normalAmount - $promoAmount,

                'discount_remarks' =>
                    '9+1 promo',

                'total_amount_due' =>
                    $promoAmount,
            ];

        } else {

            /*
            |--------------------------------------------------------------------------
            | EXISTING LEGACY CALCULATION
            |--------------------------------------------------------------------------
            */

            $participationAmount =
                $this->calculateParticipationAmount(
                    $space,
                    $booth_qty,
                    $size,
                    $request->start_up ?? false
                );

            $discountData =
                $this->applyDiscount(
                    $participationAmount
                );
        }


        /*
        |--------------------------------------------------------------------------
        | EXISTING LEGACY UPDATE
        |--------------------------------------------------------------------------
        */

        $updated = $this->updateExistingCartItem(
            $exhibitor,
            $fair_code,
            $package,
            $space,
            $size,
            $booth_qty,
            $validated['participation_type']
        );

        if ($updated) {

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT CART ITEM
        |--------------------------------------------------------------------------
        */

        $cartItem = [
            'package_id' =>
                $package->id,

            'space_id' =>
                $space->id,

            'booth_size_code' =>
                $size->id,

            'booth_size_name' =>
                $boothSizeName,

            'booth_package' =>
                $boothPackage,

            'booth_qty' =>
                $booth_qty,

            'total_participation' =>
                $participationAmount,

            'sub_total' =>
                $participationAmount,

            'discount' =>
                $discountData['discount'],

            'discount_remarks' =>
                $discountData['discount_remarks'],

            'total_amount_due' =>
                $discountData['total_amount_due'],

            'booth_amount' =>
                $boothAmount,

            'currency' =>
                $currency,

            'ff_code' =>
                $exhibitor->uid,

            'fair_code' =>
                $fair_code,

            'status' =>
                0,

            'added_by' =>
                $addedBy,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE CART ITEM
    |--------------------------------------------------------------------------
    */

    ParticipationBoothSelection::create(
        $cartItem
    );


    /*
    |--------------------------------------------------------------------------
    | HISTORY LOG
    |--------------------------------------------------------------------------
    */

    if ($addedBy !== null) {

        $description = [
            'action' =>
                'add_to_cart',

            'message' =>
                'Added to cart successfully.',

            'booth' => [

                'package' => [
                    'id' =>
                        $package->id,

                    'title' =>
                        $boothPackage,

                    'qty' =>
                        $booth_qty,
                ],

                'space' => [
                    'id' =>
                        $space->id,

                    'name' =>
                        $space->name,

                    'type' =>
                        $space->type,
                ],

                'size' => [
                    'id' =>
                        $size->id,

                    'name' =>
                        $boothSizeName,
                ],
            ],

            'pricing' => [
                'currency' =>
                    $currency,

                'booth_amount' =>
                    $boothAmount,

                'discount' =>
                    $discountData['discount'],

                'discount_remarks' =>
                    $discountData['discount_remarks'],

                'total_amount_due' =>
                    $discountData['total_amount_due'],
            ],

            'meta' => [
                'fair_code' =>
                    $fair_code,

                'ff_code' =>
                    $exhibitor->uid,

                'added_by' =>
                    $addedBy,

                'space_type' =>
                    $validated['space_type'],

                'start_up' =>
                    $validated['start_up'],
            ],
        ];

        HistoryLogHelper::log(
            $addedBy,
            $fair_code,
            $exhibitor->uid,
            'add',
            $description
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FETCH CART
    |--------------------------------------------------------------------------
    */

    $cart = Exhibitor::where(
        'uid',
        $exhibitor->uid
    )
    ->with([
        'participationSelections' => function ($query) use ($fair_code) {
            $query->where(
                'fair_code',
                $fair_code
            );
        },

        'participationSelections.package:id,title,sub_title',

        'participationSelections.space:id,name,type',

        'participationSelections.size:id,name',
    ])
    ->first();


    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

    return response()->json([
        'success' =>
            true,

        'message' =>
            'Item added to cart successfully.',

        'cart' =>
            $cart,
    ]);
}

public function delete_cart_item(Request $request)
{
    $request->validate([
        'cart_item_id' => 'required|integer|exists:participation_booth_selection,id',
        'user_id'      => 'required|integer|exists:users,id',
        'fair_code'    => 'required|string|exists:internal_events,fair_code',
    ]);

    $cartItem = ParticipationBoothSelection::findOrFail($request->cart_item_id);


        $authUser = Auth::guard('web')->user() ?: Auth::guard('supplier')->user();
    // Prepare description before deleting
    $description = [
        'action' => 'delete_cart_item',
        'message' => 'Cart item deleted successfully.',
        'cart_item' => [
            'id'    => $cartItem->id,
            'package_id' => $cartItem->package_id,
            'space_id'   => $cartItem->space_id,
            'size_id'    => $cartItem->booth_size_code,
            'qty'        => $cartItem->booth_qty,
            'total_amount_due' => $cartItem->total_amount_due,
            'currency'   => $cartItem->currency,
        ],
        'meta' => [
            'fair_code' => $cartItem->fair_code,
            'ff_code'   => $cartItem->ff_code,
            'deleted_by' =>$authUser->id,
        ],
    ];

    $cartItem->delete();

    // 

    if ($authUser) {
        HistoryLogHelper::log(
            $authUser->id,
            $request->fair_code,
            $cartItem->ff_code,
            'delete',
            $description
        );
    }

    // Fetch updated cart
    $cart = Exhibitor::where('uid', $request->user_id)
        ->participationSelectionsFairCode($request->fair_code)
        ->with([
            'participationSelections.package:id,title,sub_title',
            'participationSelections.space:id,name',
            'participationSelections.size',
        ])
        ->first();

    return response()->json([
        'success' => true,
        'message' => 'Cart item deleted successfully.',
        'cart'    => $cart,
    ]);
}

public function fetchParticipationMandatory($user_id, $fair_code)
{
    // Validate inputs early (optional but recommended if called directly)
    if (!is_numeric($user_id) || empty($fair_code)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid parameters provided.',
        ], 422);
    }

    // Fetch user
    $user = User::find($user_id);
    if (! $user) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Get exhibitor for this fair
    $exhibitor = $user->exhibitorForFair($fair_code);
    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    // Fetch mandatory participation fee
    $mandatory = ParticipationMandatory::query()
        ->where('business_type_id', $exhibitor->business_type_id)
        ->first();

    if (! $mandatory) {
        return response()->json([
            'success' => false,
            'message' => 'No mandatory participation fee found for this business type.',
            'mandatory' => null,
        ], 200);
    }

    // Success response
    return response()->json([
        'success'   => true,
        'message'   => 'Mandatory participation fee retrieved successfully.',
        'mandatory' => [
            'id'       => $mandatory->id,
            'details'  => $mandatory->details,
            'price'    => $mandatory->price,
            'currency' => $mandatory->currency,
            'is_required' => $mandatory->is_required,
        ],
    ], 200);
}
public function delete_all_cart_items(Request $request)
{
    $request->validate([
        'user_id'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $user = User::findOrFail($request->user_id);

    $authUser = Auth::guard('web')->user() ?: Auth::guard('supplier')->user();
    $addedBy = $authUser ? $authUser->id : null;

    $exhibitor = $user->exhibitorForFair($request->fair_code);

    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    $cartItems = ParticipationBoothSelection::where('ff_code', $exhibitor->uid)
        ->where('fair_code', $request->fair_code)
        ->get();

    if ($cartItems->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No cart items found. Nothing to delete.',
        ], 200);
    }

    // Prepare JSON log for all items before deletion
    $description = [
    'action' => 'delete_all_cart_items',
    'message' => 'All cart items deleted successfully.',
    'meta' => [
        'fair_code' => $request->fair_code,
        'ff_code'   => $exhibitor->uid,
        'deleted_by' => $addedBy,
    ],
];


    // Delete all cart items
    $deletedCount = ParticipationBoothSelection::where('ff_code', $exhibitor->uid)
        ->where('fair_code', $request->fair_code)
        ->delete();

    // Log deletion if user is authenticated
    if ($addedBy !== null) {
        HistoryLogHelper::log(
            $addedBy,
            $request->fair_code,
            $exhibitor->uid,
            'delete',
            $description
        );
    }

    return response()->json([
        'success'       => true,
        'message'       => 'All cart items deleted successfully.',
        'deleted_count' => $deletedCount,
    ]);
}


public function deleteAllAddOnSelection(Request $request)
{
    $request->validate([
        'user_id'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

     $authUser = Auth::guard('web')->user()
        ?: Auth::guard('supplier')->user();

    $deletedBy = $authUser ? $authUser->id : null;

    $user = User::findOrFail($request->user_id);
    $exhibitor = $user->exhibitorForFair($request->fair_code);

    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    // ✅ Use query builder to avoid IDE warnings
    $addOnQuery = ParticipationAddOnSelection::query()
        ->where('ff_code', $exhibitor->uid)
        ->where('fair_code', $request->fair_code);

    $addOnCount = $addOnQuery->count();

    if ($addOnCount === 0) {
        return response()->json([
            'success' => true,
            'message' => 'No add-on items found. Nothing to delete.',
            'empty'   => true,
        ], 200);
    }

    $description = [
        'action'  => 'delete_all_addons',
        'message' => 'All add-on selections deleted successfully.',
        'meta' => [
            'fair_code'  => $request->fair_code,
            'ff_code'    => $exhibitor->uid,
            'deleted_by'=> $deletedBy,
            'count'     => $addOnCount,
        ],
    ];

    // Delete all add-on selections
    $deleted = $addOnQuery->delete();

  $this->deleteAllPitchingSelections($request->user_id, $request->fair_code);

   if ($deletedBy !== null) {
        HistoryLogHelper::log(
            $deletedBy,
            $request->fair_code,
            $exhibitor->uid,
            'delete',
            $description
        );
    }


    return response()->json([
        'success'       => true,
        'message'       => 'All add-on selections deleted successfully.',
        'deleted_count' => $deleted,
    ]);
}

    public function deleteAllDocuments(Request $request)
{
    $request->validate([
        'user_id'   => 'required|integer|exists:users,id',
        'fair_code' => 'required|string|exists:internal_events,fair_code',
    ]);

    $user = User::findOrFail($request->user_id);
    $exhibitor = $user->exhibitorForFair($request->fair_code);

    if (! $exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'Exhibitor not found for this fair.',
        ], 404);
    }

    // Find the documents record for this exhibitor & fair
    $document = ExhibitorDocument::where('uid', $user->id)
        ->where('fair_code', $request->fair_code)
        ->first();

    if (! $document) {
        return response()->json([
            'success' => true,
            'message' => 'No uploaded requirements found. Nothing to delete.',
            'empty'   => true,
        ], 200);
    }

    // List of columns to delete
    $docFields = [
        'dti_sec',
        'bir',
        'lto',
        'cpr',
        'other_food_certificate',
        'institutional_catalog',
        'business_certification',
        'food_or_environmental_certification'
    ];

    // Delete each file if it exists
    foreach ($docFields as $column) {
        $filePath = $document->{$column};
        if ($filePath && Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    // Delete the database row
    $document->delete();

    return response()->json([
        'success' => true,
        'message' => 'All uploaded requirements and corresponding record deleted successfully.'
    ]);
    }


   


public function addPitchingCompetitionAddOn(Request $request)
{
    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'participation_addon_rate_id' => 'required|integer|exists:participation_add_on_rates,id',
        'fair_code' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    $authUser = Auth::guard('web')->user()
        ?: Auth::guard('supplier')->user();

    $addedBy = $authUser ? $authUser->id : null;

    $user = User::findOrFail($request->user_id);

    $rate = ParticipationAddOnRates::with('addOn')
        ->findOrFail($request->participation_addon_rate_id);

    $addOn = $rate->addOn;

    // 🔐 Safety check
    if (!$addOn || $addOn->id !== 5) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid pitching competition add-on.',
        ], 403);
    }

    $fairCode = $request->fair_code;
    $quantity = (int) $request->quantity;

    // Fetch existing selection (for history)
    $existingSelection = ParticipationAddOnSelection::where('ff_code', $user->id)
        ->where('fair_code', $fairCode)
        ->where('participation_addon_id', $addOn->id)
        ->first();

    /**
     * ✅ Replace instead of insert
     * ONE row per user + fair + add-on
     */
    $selection = ParticipationAddOnSelection::updateOrCreate(
        [
            'ff_code' => $user->id,
            'fair_code' => $fairCode,
            'participation_addon_id' => $addOn->id,
        ],
        [
            'qty' => $quantity,
            'total_amount_due' => 0, // Free of charge
            'added_by' => $addedBy,
        ]
    );

    /**
     * 🧾 History log (clean JSON)
     */
    if ($addedBy !== null) {

    $process = $existingSelection ? 'update' : 'add';

    $oldQty = $existingSelection ? $existingSelection->qty : null;

    $description = [
        'action' => 'pitching_competition_addon',
        'message' => 'Added pitching competition add on',
        'addon' => [
            'id'   => $addOn->id,
            'name' => $addOn->name,
        ],
        'quantity' => [
            'old' => $oldQty,
            'new' => $quantity,
        ],
        'meta' => [
            'fair_code' => $fairCode,
            'ff_code'   => $user->id,
            'added_by'  => $addedBy,
        ],
    ];

    HistoryLogHelper::log(
        $addedBy,
        $fairCode,
        $user->id,
        $process,
        $description
    );
}


    /**
     * 🔁 Reset pitching session categories
     */
    PitchingSessionCategoriesSelections::where('ff_code', $user->id)
        ->where('fair_code', $fairCode)
        ->delete();

    if (!empty($request->selected_categories)) {
        $insertData = array_map(function ($categoryId) use ($user, $fairCode) {
            return [
                'ff_code' => $user->id,
                'fair_code' => $fairCode,
                'pitching_session_category_id' => $categoryId,
                'created_at' => now(),
            ];
        }, $request->selected_categories);

        PitchingSessionCategoriesSelections::insert($insertData);
    }

    return response()->json([
        'success' => true,
        'selection' => $selection,
    ]);
}


    public function addAddOnSelection(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'participation_addon_rate_id' => 'required|integer|exists:participation_add_on_rates,id',
            'fair_code' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);


 
          $authUser = Auth::guard('web')->user() 
          ?: Auth::guard('supplier')->user();
        
        $addedBy = $authUser ? $authUser->id : null;

        $user = User::findOrFail($request->user_id);

        // Load rate with addOn relationship
        $rate = ParticipationAddOnRates::with('addOn')->findOrFail($request->participation_addon_rate_id);
        $addOn = $rate->addOn;

        if (!$addOn) {
            return response()->json([
                'success' => false,
                'message' => 'Add-on not found for this rate.',
            ], 200);
        }

        $fairCode = $request->fair_code;
        $quantity = (int) $request->quantity;

        /**
         * ✅ 1. Check TOTAL per exhibitor
         * (limit_per_exhibitor = max units user can buy in total)
         */
        $limitPerExhibitor = $addOn->limit_per_exhibitor;

        $existingQty = ParticipationAddOnSelection::where('ff_code', $user->id)
            ->where('fair_code', $fairCode)
            ->where('participation_addon_id', $addOn->id)
            ->sum('qty');

        if (!is_null($limitPerExhibitor) && ($existingQty + $quantity) > $limitPerExhibitor) {
            return response()->json([
                'success' => false,
                'message' => "You can only take a total of {$limitPerExhibitor} for this event.",
            ], 200);
        }

        /**
         * ✅ 2. Check OVERALL fair limit
         * (limit_overall = total units all exhibitors can buy)
         */
        $limitOverall = $addOn->limit_overall;

        if (!is_null($limitOverall)) {
            $totalOverall = ParticipationAddOnSelection::where('participation_addon_id', $addOn->id)
                ->where('fair_code', $fairCode)
                ->sum('qty');

            if ($totalOverall + $quantity > $limitOverall) {
                return response()->json([
                    'success' => false,
                    'message' => "This add-on has already reached its overall limit for fair {$fairCode}.",
                ], 422);
            }
        }

        /**
         * ✅ SAVE purchase
         */
        $totalAmount = $rate->cost * $quantity;

        $selection = ParticipationAddOnSelection::create([
            'ff_code' => $user->id,
            'fair_code' => $fairCode,
            'participation_addon_id' => $addOn->id,
            'qty' => $quantity,
            'total_amount_due' => $totalAmount,
             'added_by' => $addedBy,
        ]);

        if ($addedBy !== null) {

            $description = [
                'action'  => 'add_addon',
                'message' => 'Added add-on to cart.',
                'addon' => [
                    'id'       => $addOn->id,
                    'name'     => $addOn->name,
                    'rate'     => $rate->cost,
                    'quantity' => $quantity,
                    'total'    => $totalAmount,
                ],
                'meta' => [
                    'fair_code' => $fairCode,
                    'ff_code'   => $user->id,
                    'added_by'  => $addedBy,
                ],
            ];

            HistoryLogHelper::log(
                $addedBy,
                $fairCode,
                $user->id,
                'add',
                $description
            );
        }


        return response()->json([
            'success' => true,
            'selection' => $selection,
        ]);
    }


    public function fetchAddonCart($user_id, $fair_code)
    {
        // ✅ Get Exhibitor record instead of User to fetch business_type_id
        $exhibitor = Exhibitor::where('uid', $user_id)
            ->where('fair_code', $fair_code)
            ->first();

        $businessTypeId = $exhibitor->business_type_id ?? null;

        $selections = ParticipationAddOnSelection::with(['addOn', 'addOnRates'])
            ->where('ff_code', $user_id)
            ->where('fair_code', $fair_code)
            ->get()
            ->map(function ($selection) use ($businessTypeId) {
            
                $rate = $selection->addOnRates
                    ->when($businessTypeId, function ($query) use ($businessTypeId) {
                        return $query->where('business_type_id', $businessTypeId);
                    })
                    ->first();

                return [
                    'id' => $selection->id,
                    'qty' => $selection->qty,
                    'total_amount_due' => $selection->total_amount_due,
                    'currency' => $rate->currency ?? 'N/A',
                    'rate_cost' => $rate->cost ?? 0,
                    'addon_id' => $selection->participation_addon_id ?? 'N/A',
                    'addon_name' => $selection->addOn->name ?? 'N/A',
                    'unit' => $selection->addOn->unit ?? 'N/A',
                    'qty_type' => $selection->addOn->qty_type ?? 'N/A',
                    'limit_per_exhibitor' => $selection->addOn->limit_per_exhibitor ?? 'N/A',
                ];
            });

        return response()->json([
            'success' => true,
            'user_id' => $user_id,
            'fair_code' => $fair_code,
            'addon_cart' => $selections,
        ]);
    }

    public function deleteAddOnSelection(Request $request)
    {
        $request->validate([
            'addon_cart_item_id' => 'required|integer|exists:participation_add_on_selection,id',
            'user_id' => 'required|integer|exists:users,id',
            'fair_code' => 'required|string',
        ]);

        $authUser = Auth::guard('web')->user()
        ?: Auth::guard('supplier')->user();

        $deletedBy = $authUser ? $authUser->id : null;

        $item = ParticipationAddOnSelection::where('id', $request->addon_cart_item_id)
            ->where('ff_code', $request->user_id)
            ->where('fair_code', $request->fair_code)
            ->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Add-on cart item not found.'], 404);
        }

        $description = [
            'action'  => 'delete_addon',
            'message' => 'Add-on cart item deleted successfully.',
            'addon' => [
                'id'       => $item->participation_addon_id,
                'quantity' => $item->qty,
                'total'    => $item->total_amount_due,
            ],
            'meta' => [
                'fair_code' => $request->fair_code,
                'ff_code'   => $request->user_id,
                'deleted_by' => $deletedBy,
            ],
        ];

        $item->delete();

        $this->deleteAllPitchingSelections($request->user_id, $request->fair_code);

        if ($deletedBy !== null) {
            HistoryLogHelper::log(
                $deletedBy,
                $request->fair_code,
                $request->user_id,
                'delete',
                $description
            );
        }

        return response()->json(['success' => true, 'message' => 'Add-on cart item deleted.']);
    }

    public function fetchAllAgreements()
    {
        $agreements = UserAgreement::query()->select('id', 'type', 'title','checkbox_title', 'status','description')->get();

        if ($agreements->isEmpty()) {
            return response()->json([
                'message' => 'No agreements found.'
            ], 404);
        }

        return response()->json($agreements);
    }
    public function user_info_by_id($id)
{
    try {
        Log::info('user_information() called', ['id' => $id]);

        // Fetch user
        $user = User::find($id);
        if (! $user) {
            Log::error('User not found', ['id' => $id]);
            abort(404, 'User not found');
        }

        // Get latest ExhibitorAttendance (based on created_at)
        $latestAttendance = ExhibitorAttendance::where('user_id', $user->id)
            ->latest('created_at')
            ->first();

        if (! $latestAttendance) {
            Log::warning('No ExhibitorAttendance record found for user', ['user_id' => $user->id]);
            abort(404, 'No event attendance record found for this user.');
        }

        $fair_code = $latestAttendance->fair_code;
        Log::info('Using latest attendance fair_code', ['user_id' => $user->id, 'fair_code' => $fair_code]);

        if ($user->user_group === 5) {
            // Supplier/Exhibitor
            $exhibitor = $user->exhibitorForFair($fair_code);
            if (! $exhibitor) {
                Log::warning('No exhibitor found for this fair', ['user_id' => $user->id, 'fair_code' => $fair_code]);
                abort(404, 'Exhibitor not found for this fair code');
            }

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

                if ($user->category_subcategory) {
                    $catsub = [];
                    foreach ($user->category_subcategory as $key => $category) {
                        $catsub[$category->category_remarks][$key] = $category->sub_category_remarks;
                    }
                    $user['catsub'] = $catsub;
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
$user['latest_attendance'] = $latestAttendance ? $latestAttendance->toArray() : null;

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


/* Products */

public function product_list(Request $request)
{
    $per_page = (int) $request->input('per_page', 10);
    $page = (int) $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    // ✅ Start query
    $products = Product::query();

    // ✅ Only fetch products of the current supplier (uid instead of supplier_id)
    if ($request->has('supplier_id') && !empty($request->supplier_id)) {
        $products->where('uid', $request->supplier_id);
    }

    // ✅ Apply filters
    if ($request->has('filter')) {
        $filters = json_decode($request->input('filter'), true);

        if (!empty($filters['product_name'])) {
            $products->where('name', 'like', '%'.$filters['product_name'].'%');
        }

        if (!empty($filters['status'])) {
            $products->where('status', $filters['status'] === 'incomplete' ? 0 : $filters['status']);
        }
    }

    // ✅ Sorting
    if ($request->has('sort')) {
        $sort = json_decode($request->input('sort'), true);
        $products->orderBy($sort['field'], $sort['type']);
    } else {
        $products->orderBy('created_at', 'desc');
    }

    // ✅ Count before pagination
    $total_products = $products->count();

    // ✅ Paginate and map to match frontend's expected fields
    $records = $products->offset($offset)
        ->limit($per_page)
        ->get(['id', 'name as product_name', 'status', 'created_at', 'updated_at']);

    return response()->json([
        'total' => $total_products,
        'data' => $records,
    ], 200);
}




public function getProductInformation($supplier_id, $product_id)
{
    // Check product ownership under this supplier
    $product = Product::where('id', $product_id)
        ->where('uid', $supplier_id)
        ->firstOrFail();

    // Load relationships
    $product->load(['supplier', 'product_images', 'product_profiles', 'product_certifications']);

    $arr_images = [];
    $arr_profiles = [];
    $arr_certs = [];

    // ✅ Match user_information file structure handling and provide product_images with stable url
    if (!empty($product->product_images)) {
        foreach ($product->product_images as $image) {
            // Build a storage URL matching the registration controller frontend usage
            // The registration front-end expects: "/storage/exhibitors/products/" + image filename
            $storageUrl = null;
            if (!empty($image->image)) {
                // Prefer the public storage path for exhibitor product images if it exists
                $storageUrl = '/storage/exhibitors/products/' . $image->image;
            } elseif (!empty($image->image_path)) {
                // fallback to Storage::url when image_path stored
                $storageUrl = Storage::url($image->image_path);
            }

            // Keep a normalized product_images array that the JS registration/view code expects
            $arr_images[] = [
                'id' => $image->id ?? null,
                'image' => $image->image ?? null,
                'image_path' => $image->image_path ?? null,
                'img_size' => $image->img_size ?? null,
                'img_type' => $image->img_type ?? null,
                'img_ext' => $image->img_ext ?? null,
                'url' => $storageUrl,
            ];
        }

        // Provide both `product_images` (detailed) and `images` (pathinfo-style) for compatibility
        $product['product_images'] = $arr_images;
        $product['images'] = array_map(function ($img) {
            return array_merge(pathinfo($img['url'] ?? ''), [
                'id' => $img['id'],
                'url' => $img['url'],
                'filesize' => null,
            ]);
        }, $arr_images);
    }

    // ✅ Profiles
    if (!empty($product->product_profiles)) {
        foreach ($product->product_profiles as $profile) {
            $arr_profiles[] = [
                'id' => $profile->id,
                'key' => $profile->key_field ?? null,
                'value' => $profile->value_field ?? null
            ];
        }
        $product['profiles'] = $arr_profiles;
    }

    // ✅ Certifications
    if (!empty($product->product_certifications)) {
        foreach ($product->product_certifications as $cert) {
            $arr_certs[] = [
                'id' => $cert->id,
                'certificate_name' => $cert->certificate_name ?? null,
                'issued_by' => $cert->issued_by ?? null,
                'valid_until' => $cert->valid_until ?? null
            ];
        }
        $product['certifications'] = $arr_certs;
    }

    // Provide `certs_others` for frontend compatibility: find remarks for certification_id == 14
    $product['certs_others'] = null;
    if (!empty($product->product_certifications)) {
        foreach ($product->product_certifications as $pc) {
            // Some product_certifications store certification_id and remarks
            if (isset($pc->certification_id) && (int)$pc->certification_id === 14) {
                $product['certs_others'] = $pc->remarks ?? null;
                break;
            }
            // Fallback: if certification relationship model uses id and remarks
            if (isset($pc->id) && (int)$pc->id === 14) {
                $product['certs_others'] = $pc->remarks ?? null;
                break;
            }
        }
    }

    return response()->json($product, 200);
}



public function storeOrUpdateProduct(Request $request)
{
    $user = User::findOrFail($request->input('supplier_id'));
    $prod_info = json_decode($request->input('prod_info'), true);
    $product_id = $request->input('product_id');

    // --- Create or Update Product ---
    if ($product_id) {
        $product = $user->products()->find($product_id);

        if ($product) {
            $product->update([
                'name' => $prod_info['prod_name'],
                'slug' => Str::slug($prod_info['prod_name'], '-'),
                'description' => $prod_info['prod_details'],
                'store_url' => $prod_info['store_url'],
                'status' => 2,
            ]);
        } else {
            // fallback if product_id not found
            $product = $user->products()->create([
                'name' => $prod_info['prod_name'],
                'slug' => Str::slug($prod_info['prod_name'], '-'),
                'description' => $prod_info['prod_details'],
                'store_url' => $prod_info['store_url'],
                'status' => 2,
            ]);
        }
    } else {
        // New product
        $product = $user->products()->create([
            'name' => $prod_info['prod_name'],
            'slug' => Str::slug($prod_info['prod_name'], '-'),
            'description' => $prod_info['prod_details'],
            'store_url' => $prod_info['store_url'],
            'status' => 2,
        ]);
    }

    // --- Handle Product Images ---
    $destinationPath = storage_path('app/public/exhibitors/products');
    $arr_product_images = [];

    if (!empty($prod_info['prod_images_for_upload'])) {
        foreach ($prod_info['prod_images_for_upload'] as $photo) {
            $filename = md5(time() . uniqid()) . '.' . $photo['ext'];

            $productImage = Image::make($photo['urlResized']);
            $size = $productImage->filesize();

            // Save thumbnail
            $productImage->fit(360, 200, function ($constraint) {
                $constraint->upsize();
            })->save($destinationPath . '/thumbs/' . $filename);

            // Save main image
            $productImage->fit(800, 620, function ($constraint) {
                $constraint->upsize();
            })->save($destinationPath . '/' . $filename);

            $arr_product_images[] = [
                'image' => $filename,
                'img_size' => $size,
                'img_type' => 'image/' . $photo['ext'],
                'img_ext' => $photo['ext']
            ];
        }

        // Save images to DB
        $product->product_images()->createMany($arr_product_images);
    }

    // --- Product Profiles (Categories & Subcategories) ---
    if ($product->product_profiles) {
        $product->product_profiles()->delete();
    }

    $arr_categories = [];
    foreach ($prod_info['prod_profiles'] as $sub) {
        $sub_category = SubCategory::find($sub);
        if ($sub_category) {
            $arr_categories[] = [
                'category_id' => $sub_category->category_id,
                'category_remarks' => $sub_category->category->name,
                'sub_category_id' => $sub_category->id,
                'sub_category_remarks' => $sub_category->name
            ];
        }
    }
    $product->product_profiles()->createMany($arr_categories);

    // --- Certifications ---
    if ($product->product_certifications) {
        $product->product_certifications()->delete();
    }

    $arr_certifications = [];
    foreach ($prod_info['prod_certs'] as $cert) {
        $certification = Certification::find($cert);
        if ($certification) {
            $remarks = $certification->id === 14
                ? Str::title($prod_info['certs_others'])
                : $certification->name;

            $arr_certifications[] = [
                'certification_id' => $certification->id,
                'remarks' => $remarks
            ];
        }
    }
    $product->product_certifications()->createMany($arr_certifications);

    return response()->json(true, 200);
}


public function storeNewProduct(Request $request)
{
    $user = User::findOrFail($request->input('supplier_id'));

    $prod_info = json_decode($request->input('prod_info'), true) ?? [];

    // Use defaults if values are missing
    $name = $prod_info['prod_name'] ?? 'Unnamed Product';
    $description = $prod_info['prod_details'] ?? '';
    $store_url = $prod_info['store_url'] ?? '';

    // Create new product
    $product = $user->products()->create([
        'name' => $name,
        'slug' => Str::slug($name, '-'),
        'description' => $description,
        'store_url' => $store_url,
        'status' => 2,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
    ]);

    // Handle product images if any
    if (!empty($prod_info['prod_images_for_upload'])) {
        $destinationPath = storage_path('app/public/exhibitors/products');
        $arr_product_images = [];

        foreach ($prod_info['prod_images_for_upload'] as $photo) {
            $filename = md5(time() . uniqid()) . '.' . $photo['ext'];

            $productImage = Image::make($photo['urlResized']);
            $size = $productImage->filesize();

            // Save thumbnail
            $productImage->fit(360, 200, function ($constraint) {
                $constraint->upsize();
            })->save($destinationPath . '/thumbs/' . $filename);

            // Save main image
            $productImage->fit(800, 620, function ($constraint) {
                $constraint->upsize();
            })->save($destinationPath . '/' . $filename);

            $arr_product_images[] = [
                'image' => $filename,
                'img_size' => $size,
                'img_type' => 'image/' . $photo['ext'],
                'img_ext' => $photo['ext']
            ];
        }

        $product->product_images()->createMany($arr_product_images);
    }

    // Handle product profiles (categories & subcategories) if any
    if (!empty($prod_info['prod_profiles'])) {
        $arr_categories = [];
        foreach ($prod_info['prod_profiles'] as $sub) {
            $sub_category = SubCategory::find($sub);
            if ($sub_category) {
                $arr_categories[] = [
                    'category_id' => $sub_category->category_id,
                    'category_remarks' => $sub_category->category->name,
                    'sub_category_id' => $sub_category->id,
                    'sub_category_remarks' => $sub_category->name
                ];
            }
        }
        if (!empty($arr_categories)) {
            $product->product_profiles()->createMany($arr_categories);
        }
    }

    // Handle certifications if any
    if (!empty($prod_info['prod_certs'])) {
        $arr_certifications = [];
        foreach ($prod_info['prod_certs'] as $cert) {
            $certification = Certification::find($cert);
            if ($certification) {
                $remarks = $certification->id === 14
                    ? Str::title($prod_info['certs_others'] ?? '')
                    : $certification->name;

                $arr_certifications[] = [
                    'certification_id' => $certification->id,
                    'remarks' => $remarks
                ];
            }
        }
        if (!empty($arr_certifications)) {
            $product->product_certifications()->createMany($arr_certifications);
        }
    }

    return response()->json([
        'success' => true,
        'product_id' => $product->id
    ], 200);
}


    /* End Products */


    
public function payment_event_list(Request $request)
{
    $per_page = (int) $request->input('per_page', 10);
    $page = (int) $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $query = ExhibitorAttendance::with(['event', 'exhibitor'])
        ->where('is_soa_generated', 1);


         if (!empty($request->supplier_id)) {
        $query->where('user_id', $request->supplier_id);
    }

    // Filters
    if ($request->has('filter')) {
        $filters = json_decode($request->input('filter'), true);

        // Filter by event name
        if (!empty($filters['event_name'])) {
            $query->whereHas('event', function ($q) use ($filters) {
                $q->where('event_name', 'like', '%' . $filters['event_name'] . '%');
            });
        }

        // Filter by company name
        if (!empty($filters['company_name'])) {
            $query->whereHas('exhibitor', function ($q) use ($filters) {
                $q->where('co_name', 'like', '%' . $filters['company_name'] . '%');
            });
        }

        // Filter by payment status
        if (isset($filters['payment_status']) && $filters['payment_status'] !== '') {
            $query->where(function ($q) use ($filters) {
                if ($filters['payment_status'] == ExhibitorAttendance::PAYMENT_UNPAID) {
                    $q->where('payment_status', ExhibitorAttendance::PAYMENT_UNPAID)
                      ->orWhereNull('payment_status');
                } else {
                    $q->where('payment_status', $filters['payment_status']);
                }
            });
        }

        // Filter by fair_code (only on exhibitor_attendance)
        if (!empty($filters['fair_code'])) {
            $query->where('fair_code', $filters['fair_code']);
        }
    }

    // Sorting
    $sortField = $request->input('sort') ? json_decode($request->input('sort'), true)['field'] : 'created_at';
    $sortType = $request->input('sort') ? json_decode($request->input('sort'), true)['type'] : 'desc';
    $query->orderBy($sortField, $sortType);

    $total = $query->count();

    $records = $query->offset($offset)
        ->limit($per_page)
        ->get()
        ->map(function ($attendance) {
            return [
            'id' => $attendance->user_id,
            'user_id' => $attendance->user_id,           // Add this
            'event_name' => $attendance->event->event_name ?? 'N/A',
            'event_slug' => $attendance->event->slug ?? '',
            'company_name' => $attendance->exhibitor->co_name ?? 'N/A',
            'payment_status' => $attendance->payment_status ?? 0,
            'created_at' => $attendance->created_at,
            'fair_code' => $attendance->fair_code ?? '', // Add this
        ];
        });

    return response()->json([
        'total' => $total,
        'data' => $records,
    ]);
}

}