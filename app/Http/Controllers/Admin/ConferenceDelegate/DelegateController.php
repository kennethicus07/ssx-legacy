<?php

namespace App\Http\Controllers\Admin\ConferenceDelegate;

use App\Http\Controllers\Controller;
use App\Models\SSXConference;
use Illuminate\Http\Request;
use App\Models\SSXConferenceDelegate;
use App\Models\SSXConferenceBreakdown;
use Illuminate\Support\Facades\Log;
use App\Services\ConferenceRegistrationService;
use App\Mail\ConferenceRegistrationForAccounting;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\QRCodeHelper;
use App\Helpers\QRTokenHelper;
use App\Mail\ConferenceDelegateApproved;
use App\Mail\ConferenceVisitorBuyerApproved;
use App\Models\Supplier\Event;
use App\Models\SSXConferenceSoa;

class DelegateController extends Controller
{
     protected ConferenceRegistrationService $registrationService;


    public function __construct(
        ConferenceRegistrationService $registrationService
    ) {
        $this->registrationService = $registrationService;
    }
private function getDelegatePermissions(): array
{
    $user = Auth::user();

    return [
        'can_view' => $user->can('view delegates'),

        'can_edit' => $user->can('edit delegates'),

        'can_add' => $user->can('add delegates'),

        'can_delete' => $user->can('delete delegates'),

        'can_add_fee' => $user->can('add fee_delegates'),

        'can_add_discount' => $user->can('add discount_delegates'),

        'can_delete_fee' => $user->can('delete fee delegates'),

        'can_delete_discount' => $user->can('delete discount_delegates'),

           'can_review' => $user->can('review delegates'),


        'can_email' => $user->can('email delegates'),

        'can_email_visitor_buyers' => $user->can('email visitor_buyers'),

        'can_generate_soa' => $user->can('generate soa_delegates'),

        'can_approval_soa' => $user->can('approval soa_delegates'),

        'can_revert_soa' => $user->can('revert soa_delegates'),

        'can_approved_soa' => $user->can('approved soa_delegates'),

        'can_view_soa' => $user->can('view soa delegates'),

        'is_super_admin' => (int) Auth::user()->user_group === 1,

        'is_accounting' =>  (int) Auth::user()->user_group === 6,
    ];
}
private function uploadDelegateId(Request $request): ?string
{
    if (!$request->hasFile('id_file')) {
        return null;
    }

    $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);

    $extension = $request->file('id_file')->getClientOriginalExtension();

    $fileName = now()->format('Ymd_His') . "_{$randomString}.{$extension}";

    $request->file('id_file')->storeAs(
        'public/conf_uploads',
        $fileName
    );

    return $fileName;
}

private function recalculateConferenceAmount(SSXConference $conference)
{
    $breakdowns = $conference->conferenceBreakdown()->get();

    /* 
    |--------------------------------------------------------------------------
    | Original Base
    |--------------------------------------------------------------------------
    */

    $baseTotal = $breakdowns
        ->where('type', SSXConferenceBreakdown::TYPE_BASE)
        ->sum('value');

    /*
    |--------------------------------------------------------------------------
    | Existing System Discounts
    |--------------------------------------------------------------------------
    */

    $existingDiscounts = $breakdowns
        ->where('type', SSXConferenceBreakdown::TYPE_DISCOUNT)
        ->sum('value');

    /*
    |--------------------------------------------------------------------------
    | Admin Added Fees
    |--------------------------------------------------------------------------
    */

    $additionalFees = $breakdowns
        ->where('type', SSXConferenceBreakdown::TYPE_ADD_FEE)
        ->sum('value');

    /*
    |--------------------------------------------------------------------------
    | Admin Added Discounts
    |--------------------------------------------------------------------------
    */

    $additionalDiscounts = $breakdowns
        ->where('type', SSXConferenceBreakdown::TYPE_ADD_DISCOUNT)
        ->sum('value');

    /*
    |--------------------------------------------------------------------------
    | Total Discount
    |--------------------------------------------------------------------------
    */

    $totalDiscount = $existingDiscounts + $additionalDiscounts;

    /*
    |--------------------------------------------------------------------------
    | Final Amount
    |--------------------------------------------------------------------------
    */

    $amount = $baseTotal + $additionalFees;

    $finalAmount = max(
        0,
        $amount - $totalDiscount
    );

    /*
    |--------------------------------------------------------------------------
    | Update Conference
    |--------------------------------------------------------------------------
    */

    $conference->amount = $amount;
    $conference->discount = $totalDiscount;
    $conference->final_amount = $finalAmount;

    $conference->save();

    return [
        'base_total' => $baseTotal,
        'additional_fees' => $additionalFees,
        'discounts' => $totalDiscount,
        'final_amount' => $finalAmount,
    ];
}



    public function index(){
        return view('admin.registration.delegate.index');
    }

    public function view($id){
    return view('admin.registration.delegate.view', compact('id'));
    }

 public function list(Request $request)
{
    $perPage = $request->input('per_page', 10);
    $page    = $request->input('page', 1);

    $query = SSXConference::with('conferenceDelegates');

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    $filters = $request->input('filter', []);

    if (!empty($filters['registration_number'])) {
        $query->where(
            'registration_number',
            'like',
            '%' . $filters['registration_number'] . '%'
        );
    }

    if (!empty($filters['company_name'])) {
        $query->where(
            'company_name',
            'like',
            '%' . $filters['company_name'] . '%'
        );
    }

    if (!empty($filters['contact_person'])) {
        $query->where(
            'contact_person',
            'like',
            '%' . $filters['contact_person'] . '%'
        );
    }

    if (!empty($filters['company_email'])) {
        $query->where(
            'company_email',
            'like',
            '%' . $filters['company_email'] . '%'
        );
    }

    if (!empty($filters['fair_code'])) {
        $query->where('fair_code', $filters['fair_code']);
    }         

    if (isset($filters['status']) && $filters['status'] !== '') {
        $query->where('status', $filters['status']);
    }

    /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */

    $sortField = $request->input('sort.field', 'created_at');
    $sortType  = strtolower($request->input('sort.type', 'desc'));

    if (!in_array($sortType, ['asc', 'desc'])) {
        $sortType = 'desc';
    }

    $allowedSorts = [
        'registration_number',
        'company_name',
        'contact_person',
        'company_email',
        'participant_count',
        'fair_code',
        'status',
        'created_at',
    ];

    if (!in_array($sortField, $allowedSorts)) {
        $sortField = 'created_at';
    }

    $query->orderBy($sortField, $sortType);

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $records = $query->paginate(
        $perPage,
        ['*'],
        'page',
        $page
    );

    /*
    |--------------------------------------------------------------------------
    | Response Data
    |--------------------------------------------------------------------------
    */

    $data = collect($records->items())->map(function ($conference) {

        return [

            'id' => $conference->id,

            'registration_number' => $conference->registration_number,

            'company_name' => $conference->company_name,

            'contact_person' => $conference->contact_person,

            'company_email' => $conference->company_email,

            'contact_number' => $conference->contact_number,

            'fair_code' => $conference->fair_code,

            'participant_count' => $conference->participant_count,

            'status' => $conference->status,

            /*
            |--------------------------------------------------------------------------
            | Review / SOA Billing
            |--------------------------------------------------------------------------
            */

            'review' => $conference->review_status,


'billing_status' =>
    (int) $conference->billing_status,

            'created_at' => optional($conference->created_at)
                ->format('Y-m-d H:i:s'),

            /*
            |--------------------------------------------------------------------------
            | Delegates
            |--------------------------------------------------------------------------
            */

            'delegates' => $conference->conferenceDelegates->map(function ($delegate) {

                return [

                    'id' => $delegate->id,

                    'name' => $delegate->name,

                    'email' => $delegate->email,

                    'designation' => $delegate->designation,

                    'company' => $delegate->company,

                    'mobile' => $delegate->mobile,

                ];

            }),

        ];

    });

    

    return response()->json([
        'total' => $records->total(),
        'data' => $data,
    ]);
}

public function details($id)
{
    $conference = SSXConference::with([
        'conferenceDelegates',
        'conferenceBreakdown',
        'conferenceKnowhow',
    ])->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Event
    |--------------------------------------------------------------------------
    */

    $event = Event::where(
        'fair_code',
        $conference->fair_code
    )->first();


    /*
    |--------------------------------------------------------------------------
    | Latest SOA
    |--------------------------------------------------------------------------
    |
    | Get the latest generated SOA belonging to this conference.
    |
    */

    $soa = SSXConferenceSoa::where(
        'ssx_conference_id',
        $conference->id
    )
    ->latest('id')
    ->first();
 $permissions = $this->getDelegatePermissions();

    return response()->json([

        'id' => $conference->id,

        'registration_number' =>
            $conference->registration_number,

        'fair_code' =>
            $conference->fair_code,


        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        */

        'event' => $event ? [

            'id' =>
                $event->id,

            'event_name' =>
                $event->event_name,

            'location' =>
                $event->location,

            'slug' =>
                $event->slug,

            'fair_code' =>
                $event->fair_code,

            'description' =>
                $event->description,

            'event_start' =>
                optional($event->event_start)
                    ->format('Y-m-d H:i:s'),

            'event_end' =>
                optional($event->event_end)
                    ->format('Y-m-d H:i:s'),

            'registration_start' =>
                optional($event->registration_start)
                    ->format('Y-m-d H:i:s'),

            'registration_end' =>
                optional($event->registration_end)
                    ->format('Y-m-d H:i:s'),

            'status' =>
                $event->status,

            'logo' =>
                $event->logo,

            'show_info_link' =>
                $event->show_info_link,

            'masthead' =>
                $event->masthead,

            'event_date' =>
                $event->formatted_date_range,

            'formatted_date_range' =>
                $event->formatted_date_range,

        ] : null,


        /*
        |--------------------------------------------------------------------------
        | Latest SOA
        |--------------------------------------------------------------------------
        */

        'soa' => $soa ? [

            'id' =>
                $soa->id,

            'ssx_conference_id' =>
                $soa->ssx_conference_id,

            'fair_code' =>
                $soa->fair_code,

            'soa_file' =>
                $soa->soa_file,

            'soa_url' =>
                url(
                    'conference/billing/' .
                    $soa->soa_file
                ),

            /*
             * Dates
             */

            'date_issued' =>
                optional($soa->date_issued)
                    ->format('Y-m-d'),

            'date_due' =>
                optional($soa->date_due)
                    ->format('Y-m-d'),

            /*
             * VAT
             */

            'vat_rate' =>
                $soa->vat_rate,

            'vat_exempted' =>
                $soa->vat_exempted,

            'vat_zero_exempted' =>
                $soa->vat_zero_exempted,

            /*
             * Status
             */

            'status' =>
                $soa->status,

            /*
             * Users
             */

            'created_by' =>
                $soa->created_by,

            'updated_by' =>
                $soa->updated_by,

            /*
             * Timestamps
             */

            'created_at' =>
                optional($soa->created_at)
                    ->format('Y-m-d H:i:s'),

            'updated_at' =>
                optional($soa->updated_at)
                    ->format('Y-m-d H:i:s'),

        ] : null,


        /*
        |--------------------------------------------------------------------------
        | Registration
        |--------------------------------------------------------------------------
        */

        'business_type' =>
            ucfirst($conference->business_type),

        'participant_count' =>
            $conference->participant_count,

        'currency' =>
            $conference->currency,

        'base_rate' =>
            $conference->base_rate,

        'amount' =>
            $conference->amount,

        'discount' =>
            $conference->discount,

        'final_amount' =>
            $conference->final_amount,

        'company_name' =>
            $conference->company_name,

        'company_address' =>
            $conference->company_address,

        'tin' =>
            $conference->tin,

        'contact_person_salutation' =>
            $conference->contact_person_salutation,

        'contact_person' =>
            $conference->contact_person,

        'company_email' =>
            $conference->company_email,

        'contact_number' =>
            $conference->contact_number,

        'certificate' =>
            ucfirst($conference->certificate),

        'promotional_email' =>
            $conference->promotional_email,

        'billing_file' =>
            $conference->billing_file,

        'status' =>
            $conference->status,


        /*
        |--------------------------------------------------------------------------
        | Review / SOA Billing
        |--------------------------------------------------------------------------
        */

        'review' =>
            $conference->review_status,


'billing_status' =>
    (int) $conference->billing_status,


        /*
        |--------------------------------------------------------------------------
        | Timestamps
        |--------------------------------------------------------------------------
        */

        'created_at' =>
            optional($conference->created_at)
                ->format('Y-m-d H:i:s'),

        'updated_at' =>
            optional($conference->updated_at)
                ->format('Y-m-d H:i:s'),


        /*
        |--------------------------------------------------------------------------
        | Delegates
        |--------------------------------------------------------------------------
        */

        'conference_delegates' =>
            $conference->conferenceDelegates->map(function ($delegate) {

                return [

                    'id' =>
                        $delegate->id,

                    'name' =>
                        trim(
                            $delegate->salutation . ' ' .
                            $delegate->fname . ' ' .
                            $delegate->lname
                        ),

                    'salutation' =>
                        $delegate->salutation,

                    'fname' =>
                        $delegate->fname,

                    'lname' =>
                        $delegate->lname,

                    'country' =>
                        $delegate->country,

                    'designation' =>
                        $delegate->designation,

                    'email' =>
                        $delegate->email,

                    'mobile' =>
                        trim(
                            $delegate->country_code_mobile . ' ' .
                            $delegate->mobile_no
                        ),

                    'addtnl_type' =>
                        $delegate->addtnl_type,

                    'country_code_mobile' =>
                        $delegate->country_code_mobile,

                    'mobile_no' =>
                        $delegate->mobile_no,

                    'additional_type' =>
                        $delegate->addtnl_type,

                    'is_speaker' =>
                        $delegate->is_speaker,

                    'is_visitor_buyer' =>
                        $delegate->is_visitor_buyer,

                    'is_email_sent' =>
                        $delegate->is_email_sent,

                    'senior' =>
                        (bool) $delegate->senior,

                    'pwd' =>
                        (bool) $delegate->pwd,

                    'id_file' =>
                        $delegate->id_file,

                    'delegate_category' =>
                        $delegate->delegate_category,

                    'delegate_category_text' =>
                        (
                            $delegate->delegate_category ==
                            SSXConferenceDelegate::CATEGORY_DECISION_MAKER
                        )
                            ? 'Decision Maker'
                            : (
                                $delegate->delegate_category ==
                                SSXConferenceDelegate::CATEGORY_RECOMMENDING_OFFICER
                                    ? 'Recommending Officer'
                                    : (
                                        $delegate->delegate_category ==
                                        SSXConferenceDelegate::CATEGORY_TECHNICAL_REPRESENTATIVE
                                            ? 'Technical Representative'
                                            : (
                                                $delegate->delegate_category ==
                                                SSXConferenceDelegate::CATEGORY_OTHER
                                                    ? 'Others'
                                                    : '-'
                                            )
                                    )
                            ),

                    'delegate_category_other' =>
                        $delegate->delegate_category_other,
                ];
            }),


        /*
        |--------------------------------------------------------------------------
        | Breakdown
        |--------------------------------------------------------------------------
        */

        'conference_breakdown' =>
            $conference->conferenceBreakdown->map(function ($item) {

                return [

                    'id' =>
                        $item->id,

                    'code' =>
                        $item->code,

                    'system_code' =>
                        $item->system_code,

                    'type' =>
                        $item->type,

                    'count' =>
                        $item->count,

                    'value' =>
                        $item->value,

                    'description' =>
                        $item->description,
                ];
            }),


        /*
        |--------------------------------------------------------------------------
        | Know How
        |--------------------------------------------------------------------------
        */

        'conference_knowhow' =>
            $conference->conferenceKnowhow->map(function ($item) {

                return [

                    'id' =>
                        $item->id,

                    'value' =>
                        $item->value,

                    'know_how_other' =>
                        $item->know_how_other,

                    'display' =>
                        $item->value === 'Other'
                        && !empty($item->know_how_other)

                            ? 'Other: ' .
                                $item->know_how_other

                            : $item->value,
                ];
            }),

             'permissions' => $permissions,
    ]);
}

    public function addFee(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'value' => 'required|numeric|min:0.01',
            'count' => 'nullable|integer|min:1',
        ]);

        $conference = SSXConference::findOrFail($id);

        $breakdown = new SSXConferenceBreakdown();

        $breakdown->code = null;
        $breakdown->system_code = null;
        $breakdown->type = SSXConferenceBreakdown::TYPE_ADD_FEE;
        $breakdown->count = $request->input('count', 1);
        $breakdown->value = $request->input('value');
        $breakdown->description = $request->input('description');

        $conference->conferenceBreakdown()->save($breakdown);

        $totals = $this->recalculateConferenceAmount($conference);

    return response()->json([
        'message' => 'Additional fee added successfully.',
        'breakdown' => [
            'id' => $breakdown->id,
            'type' => $breakdown->type,
            'count' => $breakdown->count,
            'value' => $breakdown->value,
            'description' => $breakdown->description,
        ],
        'totals' => $totals,
    ]);


        
    }

    public function addDiscount(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'value' => 'required|numeric|min:0.01',
            'count' => 'nullable|integer|min:1',
        ]);

        $conference = SSXConference::findOrFail($id);

        $breakdown = new SSXConferenceBreakdown();

        $breakdown->code = null;
        $breakdown->system_code = null;
        $breakdown->type = SSXConferenceBreakdown::TYPE_ADD_DISCOUNT;
        $breakdown->count = $request->input('count', 1);
        $breakdown->value = $request->input('value');
        $breakdown->description = $request->input('description');

        $conference->conferenceBreakdown()->save($breakdown);

        $totals = $this->recalculateConferenceAmount($conference);

        return response()->json([
            'message' => 'Additional discount added successfully.',
            'breakdown' => [
                'id' => $breakdown->id,
                'type' => $breakdown->type,
                'count' => $breakdown->count,
                'value' => $breakdown->value,
                'description' => $breakdown->description,
            ],
            'totals' => $totals,
        ]);

    }

    public function deleteBreakdown($id)
    {
        $breakdown = SSXConferenceBreakdown::findOrFail($id);

        if (!in_array($breakdown->type, [
            SSXConferenceBreakdown::TYPE_ADD_FEE,
            SSXConferenceBreakdown::TYPE_ADD_DISCOUNT,
        ])) {
            return response()->json([
                'message' => 'This breakdown cannot be deleted.'
            ], 422);
        }

        $conference = SSXConference::findOrFail(
            $breakdown->ssx_conference_id
        );

        $breakdown->delete();

        $totals = $this->recalculateConferenceAmount($conference);

       return response()->json([
    'message' => 'Adjustment removed successfully.',
    'id' => $breakdown->id,
    'totals' => $totals,
]);
    }

  public function addDelegate(Request $request, $conferenceId)
    {
        Log::info('Add Delegate Request', [
            'all' => $request->all(),
            'senior' => $request->input('senior'),
            'pwd' => $request->input('pwd'),
        ]);

        $request->validate([
            'salutation' => 'required|string|max:20',
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'designation' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'country_code_mobile' => 'required|string|max:10',
            'mobile_no' => 'required|string|max:30',
            'addtnl_type' => 'required|string',
            'delegate_category' => 'required|integer',
            'delegate_category_other' => 'nullable|string|max:255',
            'is_speaker' => 'boolean',
            'is_visitor_buyer' => 'boolean',
            'senior' => 'boolean',
            'pwd' => 'boolean',

            // File Upload
            'id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ]);

        $conference = SSXConference::findOrFail($conferenceId);

        $fileName = $this->uploadDelegateId($request);

        $delegate = new SSXConferenceDelegate();

        $delegate->fill([
           'qr_token' => QRTokenHelper::generateToken(
            QRTokenHelper::TYPE_DELEGATE
        ),
            'salutation' => $request->salutation,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'country' => $request->country,
            'designation' => $request->designation,
            'email' => $request->email,
            'country_code_mobile' => $request->country_code_mobile,
            'mobile_no' => $request->mobile_no,
            'addtnl_type' => $request->addtnl_type,
            'delegate_category' => $request->delegate_category,
            'delegate_category_other' => $request->delegate_category_other,
            'is_speaker' => $request->boolean('is_speaker'),
            'is_visitor_buyer' => $request->boolean('is_visitor_buyer'),
            'senior' => $request->boolean('senior'),
            'pwd' => $request->boolean('pwd'),
            'id_file' => $fileName,
        ]);

        

        $conference->conferenceDelegates()->save($delegate);

        $totals = $this->registrationService
    ->recompute($conference);

        return response()->json([
            'message' => 'Delegate added successfully.',
            'totals' => $totals,
            'breakdowns' => $conference->conferenceBreakdown()->get(),
            'delegate' => [
                'id' => $delegate->id,
                'salutation' => $delegate->salutation,
                'fname' => $delegate->fname,
                'lname' => $delegate->lname,
                'country' => $delegate->country,
                'designation' => $delegate->designation,
                'email' => $delegate->email,
                'country_code_mobile' => $delegate->country_code_mobile,
                'mobile_no' => $delegate->mobile_no,
                'delegate_category' => $delegate->delegate_category,
                'delegate_category_text' => $delegate->delegateCategoryText(),
                'delegate_category_other' => $delegate->delegate_category_other,
                'addtnl_type' => $delegate->addtnl_type,
                'is_speaker' => $delegate->is_speaker,
                'is_visitor_buyer' => $delegate->is_visitor_buyer,
                'senior' => $delegate->senior,
                'pwd' => $delegate->pwd,
                'id_file' => $delegate->id_file,
            ],
        ]);
    }

    public function deleteDelegate($delegateId)
    {
        $delegate = SSXConferenceDelegate::findOrFail($delegateId);


        $conference = SSXConference::findOrFail(
            $delegate->ssx_conference_id
        );


        $delegate->delete();


        /*
        |--------------------------------------------------------------------------
        | Recompute Registration Amount
        |--------------------------------------------------------------------------
        */

        $totals = $this->registrationService
            ->recompute($conference);


    return response()->json([

        'message' => 'Delegate removed successfully.',

        'totals' => $totals,

        'breakdowns' => $conference
            ->conferenceBreakdown()
            ->get(),

    ]);
    }

    public function updateDelegate(Request $request, $id)
    {
        $request->validate([
            'salutation' => 'required|string|max:20',
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'designation' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'country_code_mobile' => 'required|string|max:10',
            'mobile_no' => 'required|string|max:30',
            'addtnl_type' => 'required|string',
            'delegate_category' => 'required|integer',
            'delegate_category_other' => 'nullable|string|max:255',
            'is_speaker' => 'boolean',
            'is_visitor_buyer' => 'boolean',
            'senior' => 'boolean',
            'pwd' => 'boolean',
            'remove_id_file' => 'boolean',
            'id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:1024',
        ]);

        $delegate = SSXConferenceDelegate::findOrFail($id);

        $conference = SSXConference::findOrFail(
            $delegate->ssx_conference_id
        );

        /*
        |--------------------------------------------------------------------------
        | Existing File
        |--------------------------------------------------------------------------
        */

        $fileName = $delegate->id_file;

        /*
        |--------------------------------------------------------------------------
        | Remove Existing File
        |--------------------------------------------------------------------------
        */

        if ($request->boolean('remove_id_file')) {
            $fileName = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Replace Existing File
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('id_file')) {
            $fileName = $this->uploadDelegateId($request);
        }

        /*
        |--------------------------------------------------------------------------
        | Update Delegate
        |--------------------------------------------------------------------------
        */

        $delegate->update([

            'salutation' => $request->salutation,

            'fname' => $request->fname,

            'lname' => $request->lname,

            'country' => $request->country,

            'designation' => $request->designation,

            'email' => $request->email,

            'country_code_mobile' => $request->country_code_mobile,

            'mobile_no' => $request->mobile_no,

            'addtnl_type' => $request->addtnl_type,

            'delegate_category' => $request->delegate_category,

            'delegate_category_other' => $request->delegate_category_other,

            'is_speaker' => $request->boolean('is_speaker'),
            
            'is_visitor_buyer' => $request->boolean('is_visitor_buyer'),

            'senior' => $request->boolean('senior'),

            'pwd' => $request->boolean('pwd'),

            'id_file' => $fileName,

        ]);

        
        $totals = $this->registrationService->recompute($conference);

        return response()->json([
            'message' => 'Delegate updated successfully.',
            'totals' => $totals,
            'breakdowns' => $conference->conferenceBreakdown()->get(),
            'delegate' => [
                'id' => $delegate->id,
                'salutation' => $delegate->salutation,
                'fname' => $delegate->fname,
                'lname' => $delegate->lname,
                'country' => $delegate->country,
                'designation' => $delegate->designation,
                'email' => $delegate->email,
                'country_code_mobile' => $delegate->country_code_mobile,
                'mobile_no' => $delegate->mobile_no,
                'delegate_category' => $delegate->delegate_category,
                'delegate_category_text' => $delegate->delegateCategoryText(),
                'delegate_category_other' => $delegate->delegate_category_other,
                'addtnl_type' => $delegate->addtnl_type,
                'is_speaker' => $delegate->is_speaker,
                'is_visitor_buyer' => $delegate->is_visitor_buyer,
                'senior' => $delegate->senior,
                'pwd' => $delegate->pwd,
                'id_file' => $delegate->id_file,
            ],
        ]);
    }

public function review($id)
{
    $conference = SSXConference::findOrFail($id);

    // Only active registrations can be reviewed
    if ((int) $conference->status !== SSXConference::STATUS_REGISTERED) {
        return response()->json([
            'message' => 'This registration cannot be reviewed.',
        ], 422);
    }

    // Already reviewed
    if ((int) ($conference->is_review ?? 0) === 1) {
        return response()->json([
            'message' => 'This registration has already been reviewed.',
        ], 422);
    }

    $conference->is_review = 1;
    $conference->review_by = Auth::id();
    $conference->review_at = now();

    $conference->save();

    /*
    |--------------------------------------------------------------------------
    | Email Accounting
    |--------------------------------------------------------------------------
    */

    if (app()->environment('local')) {

        $accountingEmails = [
            'kgtecson.citem@gmail.com',
        ];

    } else {

        $accountingEmails = EmailHelper::parseList(
            env('BCC_Accounting')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Send Email
    |--------------------------------------------------------------------------
    */

    if (!empty($accountingEmails)) {

        Mail::to($accountingEmails)
            ->send(
                new ConferenceRegistrationForAccounting(
                    $conference->registration_number,
                    $conference->company_name,
                    $conference->contact_person,
                    $conference->company_email,
                    $conference->final_amount
                )
            );
    }

    return response()->json([
        'message' => 'Registration reviewed successfully.',
        'review' => $conference->review_status,
        'workflow_status' => $conference->workflow_status,
    ]);
}

public function generateAllQr($conferenceId)
{
    $conference = SSXConference::findOrFail($conferenceId);

    $delegates = $conference->conferenceDelegates()->get();

    if ($delegates->isEmpty()) {
        return response()->json([
            'message' => 'No delegates found for this registration.'
        ], 422);
    }

    foreach ($delegates as $delegate) {

        /*
        |--------------------------------------------------------------------------
        | Delete Existing QR
        |--------------------------------------------------------------------------
        */

        if (!empty($delegate->qr_file)) {

            $oldQrPath = 'conference/qr/' . $delegate->qr_file;

            if (Storage::disk('public')->exists($oldQrPath)) {
                Storage::disk('public')->delete($oldQrPath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Generate New Token
        |--------------------------------------------------------------------------
        */

        $delegate->qr_token = Str::random(32);

        /*
        |--------------------------------------------------------------------------
        | QR Filename
        |--------------------------------------------------------------------------
        */

        $fileName = 'delegate_' . $delegate->id . '.png';

        /*
        |--------------------------------------------------------------------------
        | URL Encoded In QR
        |--------------------------------------------------------------------------
        */

        $scanUrl = url(
            '/admin/registration/delegates/scan/' .
            $delegate->qr_token
        );

        /*
        |--------------------------------------------------------------------------
        | Generate PNG QR
        |--------------------------------------------------------------------------
        */

        QRCodeHelper::generate(
            $scanUrl,
            $fileName
        );

        /*
        |--------------------------------------------------------------------------
        | Save QR Filename
        |--------------------------------------------------------------------------
        */

        $delegate->qr_file = $fileName;

        $delegate->save();
    }

    return response()->json([
        'message' => 'QR codes generated successfully.',
        'count' => $delegates->count(),
    ]);
}

public function scanQr($token)
{
    $delegate = SSXConferenceDelegate::with('conference')
        ->where('qr_token', $token)
        ->first();

    if (!$delegate) {
        return response()->json([
            'message' => 'Invalid QR code.'
        ], 404);
    }

    $conference = $delegate->conference;

    return response()->json([
        'message' => 'Delegate found.',

        'conference' => [
            'id' => $conference->id,
            'registration_number' => $conference->registration_number,
            'fair_code' => $conference->fair_code,
            'business_type' => $conference->business_type,
            'participant_count' => $conference->participant_count,
            'currency' => $conference->currency,
            'base_rate' => $conference->base_rate,
            'amount' => $conference->amount,
            'discount' => $conference->discount,
            'final_amount' => $conference->final_amount,
            'company_name' => $conference->company_name,
            'company_address' => $conference->company_address,
            'tin' => $conference->tin,
            'contact_person' => $conference->contact_person,
            'company_email' => $conference->company_email,
            'contact_number' => $conference->contact_number,
            'dietary' => $conference->dietary,
            'dietary_details' => $conference->dietary_details,
            'certificate' => $conference->certificate,
            'promotional_email' => $conference->promotional_email,
            'billing_file' => $conference->billing_file,
            'status' => $conference->status,
        ],

        'delegate' => [
            'id' => $delegate->id,
            'salutation' => $delegate->salutation,
            'fname' => $delegate->fname,
            'lname' => $delegate->lname,
            'name' => trim(
                $delegate->salutation . ' ' .
                $delegate->fname . ' ' .
                $delegate->lname
            ),

            'country' => $delegate->country,
            'designation' => $delegate->designation,
            'email' => $delegate->email,

            'country_code_mobile' =>
                $delegate->country_code_mobile,

            'mobile_no' =>
                $delegate->mobile_no,

            'mobile' => trim(
                $delegate->country_code_mobile . ' ' .
                $delegate->mobile_no
            ),

            'addtnl_type' => $delegate->addtnl_type,

            'senior' => (bool) $delegate->senior,
            'pwd' => (bool) $delegate->pwd,

            'id_file' => $delegate->id_file,

            'delegate_category' =>
                $delegate->delegate_category,

            'delegate_category_text' =>
                $delegate->delegateCategoryText(),

            'delegate_category_other' =>
                $delegate->delegate_category_other,
        ],
    ]);
}

public function sendEmail($id)
{
    $delegate = SSXConferenceDelegate::with('conference')
        ->findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Get Internal Event
    |--------------------------------------------------------------------------
    */

    $event = null;

    if ($delegate->conference) {
        $event = Event::where(
            'fair_code',
            $delegate->conference->fair_code
        )->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Determine Recipient Type
    |--------------------------------------------------------------------------
    */

    $isVisitorBuyer = (int) $delegate->is_visitor_buyer === 1;

    $recipientType = $isVisitorBuyer
        ? 'Visitor/Buyer'
        : 'Delegate';

    /*
    |--------------------------------------------------------------------------
    | Log for Testing
    |--------------------------------------------------------------------------
    */

    Log::info('Conference Delegate Email', [
        'delegate_id' => $delegate->id,

        'name' => trim(
            $delegate->salutation . ' ' .
            $delegate->fname . ' ' .
            $delegate->lname
        ),

        'email' => $delegate->email,

        'is_visitor_buyer' => $delegate->is_visitor_buyer,

        'recipient_type' => $recipientType,

        'conference_id' => $delegate->conference
            ? $delegate->conference->id
            : null,

        'registration_number' => $delegate->conference
            ? $delegate->conference->registration_number
            : null,

        'fair_code' => $delegate->conference
            ? $delegate->conference->fair_code
            : null,

        'event_name' => $event
            ? $event->event_name
            : null,
    ]);

    /*
    |--------------------------------------------------------------------------
    | Determine Email
    |--------------------------------------------------------------------------
    */

    if ($isVisitorBuyer) {

        $mail = new ConferenceVisitorBuyerApproved(
            $delegate,
            $event
        );

    } else {

        $mail = new ConferenceDelegateApproved(
            $delegate,
            $event
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Send Email
    |--------------------------------------------------------------------------
    */

    if (env('APP_ENV') != 'local') {

        Mail::to($delegate->email)
            ->send($mail);

    } else {

        Mail::to('kgtecson.citem@gmail.com')
            ->send($mail);
    }

    /*
    |--------------------------------------------------------------------------
    | Mark Email as Sent
    |--------------------------------------------------------------------------
    */

    $delegate->is_email_sent = 1;
    $delegate->email_sent_at = now();

    $delegate->save();

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    return response()->json([
        'message' => "Email sent successfully to {$recipientType}.",

        'recipient_type' => $recipientType,

        'email' => $delegate->email,

        'event_name' => $event
            ? $event->event_name
            : null,

        'is_email_sent' => $delegate->is_email_sent,

        'email_sent_at' => $delegate->email_sent_at,
    ]);
}
    }
