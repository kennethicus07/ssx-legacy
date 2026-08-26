<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Conference;
use App\Models\SSXConference;
use App\Models\SSXConferenceBreakdown;
use App\Models\SSXConferenceDelegate;
use App\Models\SSXConferenceKnowhow;
use App\Models\IFEXConferenceCode;
use Illuminate\Support\Carbon;

use App\Mail\CompleteConferenceRegistration;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

use Meta;

class ConferenceController extends Controller
{
    public function __construct() {
        

        $reg_cutoff = Carbon::create(2026, 5, 20);
        $deadline = Carbon::create(2026, 4, 30);
        $today = Carbon::now('Asia/Manila')->startOfDay();

        $this->reg_open = $today->lte($reg_cutoff) ? true : false;
        $this->delegate_limit = 150;

        $this->special_baserate_active = true && $today->lte($deadline) == false;

        // xp100, FREE ALL
        
        if($today->lte($deadline)){
            // Pre 2025-04-30
            $this->discounts = [
                ['code' => 'ssxSeat', 'type' => 'base', 'value' => 1, 'desc' => 'SSX Exhibitor Free Seat'],
                ['code' => 'spc20', 'type' => 'base_pct', 'value' => .2, 'desc' => '20% Government,Academe, Students, Senior Citizens, PWDs Discount'],
                ['code' => 'exb30', 'type' => 'base_pct', 'value' => .3, 'desc' => '30% Exhibitor Discount'],
                ['code' => 'genExb30', 'type' => 'base_pct', 'value' => .3, 'desc' => '30% Exhibitor Discount'],
                ['code' => '5plus1', 'type' => 'base', 'value' => 1, 'desc' => 'Group (5 + 1 Free)'],
                ['code' => 'euSeat', 'type' => 'base', 'value' => 1, 'desc' => 'EU Visitor Free Seat'],
                ['code' => 'xp100', 'type' => 'base', 'value' => 1, 'desc' => 'Free General Pass']
            ];
        }
        else {
            $this->discounts = [
                ['code' => 'ssxSeat', 'type' => 'base', 'value' => 1, 'desc' => 'SSX Exhibitor Free Seat'],
                ['code' => 'spc20', 'type' => 'exact', 'value' => [2000,54], 'desc' => 'Government,Academe, Students, Senior Citizens, PWDs Discount'],
                ['code' => 'exb30', 'type' => 'exact', 'value' => [2500,66], 'desc' => 'Exhibitor Discount'],
                ['code' => 'genExb30', 'type' => 'exact', 'value' => [2500,66], 'desc' => 'Exhibitor Discount'],
                ['code' => '5plus1', 'type' => 'base', 'value' => 1, 'desc' => 'Group (5 + 1 Free)'],
                ['code' => 'euSeat', 'type' => 'base', 'value' => 1, 'desc' => 'EU Visitor Free Seat'],
                ['code' => 'xp100', 'type' => 'base', 'value' => 1, 'desc' => 'Free General Pass']
            ];
        }
        

        $this->oneTimePerRegSystemCodes = ['ssxSeat','genExb30','exb30','xp100'];
        $this->repeatingGenCodes = ['ssxSeat','genExb30','euSeat','xp100'];
        
        $this->fees = [
            'rateLocal' => $today->lte($deadline) ? 5000 : 6000,
            'rateForeign' => $today->lte($deadline) ? 120 : 150
        ];
    }

    public function index() {


        $conferences = Conference::whereHas('videos', function (Builder $query) {
            $query->where('status', 1);
        })->where('status', 1)->orderBy('conference_date', 'asc')->get();

        $meta_tag = DB::table('seo_meta_tags_pages')->where('page', '=', 'digital-exhibition-conference')->first();
        
        Meta::title($meta_tag->meta_title);
        Meta::set('robots', $meta_tag->meta_robots);
        Meta::set('keywords', $meta_tag->meta_keywords);
        Meta::set('description', $meta_tag->meta_description);
        if (!empty($meta->meta_author)) {
            Meta::set('author', $meta_tag->meta_author);
        }
        if (!empty($meta->meta_image)) {
            Meta::set('image', asset('storage/app/public/meta_images/'.$meta->meta_image));
        }
        Meta::set('canonical', url()->current());

        return view('website.exhibition.index', compact('conferences'));
    }
    
    public function registrationForm(){

       $fairCode = 'SSX2026'; 

        $delegateCount = SSXConferenceDelegate::whereHas('conference', function ($query) use ($fairCode) {
            $query->perFair($fairCode)->active();
            })->count();

        // if(!$this->reg_open || $delegateCount > $this->delegate_limit){
        //     return redirect()->route('home');
        // }

        $ssxConf = new SSXConference;
        $ssxConf->status = 0;
        $ssxConf->save();

        return view('website.conference.registration', ['id' => $ssxConf->id]);
    }

    // public function getConferenceRates(){

    //     $deadline = Carbon::create(2025, 4, 30);
    //     $today = Carbon::now();

    //     $fees = [
    //         'rateLocal' => $today->lte($deadline) ? 5000 : 6000,
    //         'rateForeign' => $today->lte($deadline) ? 120 : 150
    //     ];

    //     return response()->json(['fees' => $fees, 'discounts' => $this->discounts], 200);
    // }

    
    private function generateRegistrationNumber() {
        $prefix = 'SSXCONF2026';
        $datePart = date('md'); // Gets current month and day (e.g., 0322)

        // Find the last entry in the database
        $lastEntry = SSXConference::where('registration_number', 'LIKE', "$prefix-%")
            ->orderBy('registration_number', 'desc')
            ->first();

        // Extract the last increment number and increase it
        if ($lastEntry) {
            preg_match('/\d+$/', $lastEntry->registration_number, $matches);
            $lastNumber = isset($matches[0]) ? (int) $matches[0] : 0;
        } else {
            $lastNumber = 0;
        }

        // Increment and format as 4 digits (e.g., 0001, 0002)
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Generate new code
        $newCode = "$prefix-$datePart-$newNumber";

        return $newCode;
    }

    public function checkConferenceCode(Request $request) {
        $promo_code = $request->input('promo_code');
        $conference_id = $request->input('conf_id');

        $localCodeCheck = SSXConferenceBreakdown::where('code', $promo_code)->whereNotIn('system_code', $this->repeatingGenCodes)->exists();

        if($localCodeCheck) {
            return response()->json(['message' => 'Promo Code has been availed.'], 409);
        }
        
        $externalCodeCheck = IFEXConferenceCode::where('promo_code', $promo_code)
            ->where('fair_code', 'IFEXDTCP2025')
            ->first();

        if(!$externalCodeCheck) {
            return response()->json(['message' => 'Promo Code is invalid.'], 400);
        }

        $promo_system_code = $externalCodeCheck->system_code;

        // FROM no repeating system_code
        // $conference = SSXConference::find($conference_id);
        // $localCodeCheck = $conference->conferenceBreakdown()->whereIn('system_code', $promo_system_code)->exists();

        // TO only one promo at a time
        $conference = SSXConference::find($conference_id);
        $localCodeCheck = $conference->conferenceBreakdown()->whereIn('system_code', $this->oneTimePerRegSystemCodes)->exists();


        if($localCodeCheck) {
            return response()->json(['message' => 'Only 1 Promo Code is allowed.'], 400);
        }

        $discount = collect($this->discounts)->firstWhere('code', $promo_system_code);

        if(!$discount) {
            return response()->json(['message' => 'Promo Code type is invalid.'], 400);
        }

        $newConferenceBreakdown = new SSXConferenceBreakdown;
        $newConferenceBreakdown->code = $promo_code;
        $newConferenceBreakdown->system_code = $promo_system_code;
        $newConferenceBreakdown->type = 'discount';
        $newConferenceBreakdown->count = 1;
        $newConferenceBreakdown->value = null;
        $newConferenceBreakdown->description = $discount['desc'];
        $conference->conferenceBreakdown()->save($newConferenceBreakdown);
        
        return response()->json(['message' => 'Promo Code added.'], 200);
    }

    public function computeConference(Request $request) {
        $conference_id = $request->input('conf_id');
        $type = $request->input('type');
        $state = $request->input('state');
        $currency = '';
        $base_rate = 0;
        $base_total = 0;
        $discounts_total = 0;
        $discounts = [];

        if($type == 'foreign') {
            $base_rate = $this->fees['rateForeign'];
            $currency = 'USD';
        }
        else {
            $base_rate = $this->fees['rateLocal'];
            $currency = 'PHP';
        }

        $conference = SSXConference::find($conference_id);
        

        if(!$conference) {
            return response()->json(['message' => 'Invalid Request.'], 400);
        }

        $conferenceDelegatesCount = $conference->conferenceDelegates()->count();
        

        if($conferenceDelegatesCount > 0) {
            $base_total = $base_rate * $conferenceDelegatesCount;
            
            // $conferenceDelegates = $conference->conferenceDelegates()->get();
            $temp = $conference->conferenceBreakdown()->where('system_code', 'spc20')->get();

            if($temp) {
                $conference->conferenceBreakdown()->where('system_code', 'spc20')->delete();
            }

            $spcDelegatesCount = $conference->conferenceDelegates()
                ->where(function ($query) {
                    $query->whereIn('addtnl_type', ['Government', 'AcademeStudent'])
                        ->orWhere('senior', 1)
                        ->orWhere('pwd', 1);
                })->count();


            // Special Rates
            if($spcDelegatesCount > 0) {
                $discount = collect($this->discounts)->firstWhere('code', 'spc20');
                $newVal = $this->computeDiscount($base_rate, 'spc20', $type == 'foreign' ? 1: 0);

                $newConferenceBreakdown = new SSXConferenceBreakdown;
                $newConferenceBreakdown->code = null;
                $newConferenceBreakdown->system_code = $discount['code'];
                $newConferenceBreakdown->type = 'discount';
                $newConferenceBreakdown->count = $spcDelegatesCount;
                $newConferenceBreakdown->value = $newVal * $spcDelegatesCount;
                $newConferenceBreakdown->description = $discount['desc'];
                $conference->conferenceBreakdown()->save($newConferenceBreakdown);

                $discounts_total += $newConferenceBreakdown->value;

                $discounts[] = [
                    'count' => $newConferenceBreakdown->count,
                    'desc' => $newConferenceBreakdown->description
                ];
            }

            // Promos Recompute
            $confBreakdownPromos = $conference->conferenceBreakdown()->whereNotIn('system_code', ['spc20','xp100'])->get();

            if($confBreakdownPromos) {
                foreach($confBreakdownPromos as $promo) {
                    $newVal = $this->computeDiscount($base_rate, $promo->system_code, $type == 'foreign' ? 1: 0);
                    $promo->value = $newVal * $promo->count;
                    $promo->update();

                    $discounts_total += $promo->value;

                    $discounts[] = [
                        'count' => $promo->count,
                        'desc' => $promo->description
                    ];
                }
            }

            // GROUP (5 + 1 Free)
            $checkFreeSeat = $conference->conferenceBreakdown()->whereIn('system_code', ['ssxSeat','euSeat'])->exists();

            if($conferenceDelegatesCount == 6 && !$checkFreeSeat) {
                $temp = $confBreakdownPromos->where('system_code', 'exb30')->get();
                if($temp) {
                    $confBreakdownPromos->where('system_code', 'exb30')->delete();
                }

                $discount = collect($this->discounts)->firstWhere('code', '5plus1');

                $discCompute = $this->computeDiscount($base_rate, $discount['code'], $type == 'foreign' ? 1: 0);
                
                if($state == 1) {

                    // GROUP (5 + 1 Free)
                    $newConferenceBreakdown = new SSXConferenceBreakdown;
                    $newConferenceBreakdown->code = null;
                    $newConferenceBreakdown->system_code = $discount['code'];
                    $newConferenceBreakdown->type = 'discount';
                    $newConferenceBreakdown->count = 1;
                    $newConferenceBreakdown->value =$discCompute;
                    $newConferenceBreakdown->description = $discount['desc'];
                    $conference->conferenceBreakdown()->save($newConferenceBreakdown);
                }

                $discounts_total += $discCompute;
                
                $discounts[] = [
                    'count' => 1,
                    'desc' => $discount['desc']
                ];
            }

            $final_amount = ($base_total - $discounts_total) <= 0 ? 0 : ($base_total - $discounts_total);


            // xp100 FREE TO ALL DELEGATES. FINAL AMOUNT Override
            $checkxp100 = $conference->conferenceBreakdown()->whereIn('system_code', ['xp100'])->exists();
            if($checkxp100) {
                $xp100 = $conference->conferenceBreakdown()->whereIn('system_code', ['xp100'])->first();
                $xp100->value = $final_amount;
                $xp100->update();

                $discounts_total += $final_amount;
                $final_amount = 0;

                $discounts[] = [
                    'count' => $xp100->count,
                    'desc' => $xp100->description,
                ];
            }


            
            if($state == 1) {
                // CONFERENCE DATA
                $conference->business_type = $type;
                $conference->participant_count = $conferenceDelegatesCount;
                $conference->currency = $currency;
                $conference->base_rate = $base_rate;
                $conference->amount = $base_total;
                $conference->discount = $discounts_total;
                $conference->final_amount = $final_amount;
                $conference->update();

                // BASE
                $newConferenceBreakdown = new SSXConferenceBreakdown;
                $newConferenceBreakdown->code = null;
                $newConferenceBreakdown->system_code = null;
                $newConferenceBreakdown->type = 'base';
                $newConferenceBreakdown->count = 0;
                $newConferenceBreakdown->value = $base_total;
                $newConferenceBreakdown->description = $conferenceDelegatesCount . ' x Delegates';
                $conference->conferenceBreakdown()->save($newConferenceBreakdown);
            }
            
        }
        
        
        return response()->json([
            // 'base_rate' => $base_rate,
            'base_total' => $base_total,
            'discounts_total' => $discounts_total,
            'discounts' => $discounts,
            'participant_count' => $conferenceDelegatesCount
        ], 200);
    }

    private function generateBillingPDF($conf_id) {
        $conf = SSXConference::with(['conferenceBreakdown' => function($query){
            $query->where('type', 'discount');
        }])->find($conf_id);

        $timestamp = now()->format('Ymd_His');
        $or_filename = $conf->registration_number . '_billing_' . $timestamp . '.pdf';
        $pdf = Pdf::loadView('emails.conference.conference-billing', ['conf' => $conf])
            ->setPaper('a4', 'portrait')
            ->save('conference/billing/' . $or_filename);

        return $or_filename;
    }
    
    private function computeDiscount($base_rate, $system_code, $type) {
        $discount = collect($this->discounts)->firstWhere('code', $system_code);
        $newVal = 0;

        switch($discount['type']) {
            case 'base':
                $newVal = $base_rate;
                break;
            case 'base_pct':
                $newVal = $base_rate * $discount['value'];
                break;
            case 'exact':
                if($this->special_baserate_active){
                    $newVal = $discount['value'][$type];
                }
                break;
        }

        return $newVal;
    }

    public function storeConferenceParticipant(Request $request) {

        // $request->validate([
        //     'participant' => 'required|json',
        //     'conf_id' => 'required|exists:ssx_conference,id'
        // ]);

        $participant = json_decode($request->input('participant'), true) ?? [];
        $conf_id = $request->input('conf_id') ?? '';
        $fileName = '';

        if(empty($participant) || !is_array($participant) || empty($conf_id)) {
            return response()->json(['error' => 'Invalid data provided'], 401);
        }

        if ($request->hasFile('id_file_selected')) {
            $randomString = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
            $extension = $request->file('id_file_selected')->getClientOriginalExtension();
            $fileName = now()->format('Ymd_His') . "_$randomString.$extension";
            $filePath = $request->file('id_file_selected')->storeAs('public/conf_uploads', $fileName);
        }

        $conference = SSXConference::find($conf_id);

        if(!$conference) {
            return response()->json(['error' => 'Not found'], 404);
        }
        
        $confDelegate = new SSXConferenceDelegate;
        $confDelegate->fill([
            'salutation' => $participant['salutation'] ?? null,
            'fname' => $participant['fname'] ?? null,
            'lname' => $participant['lname'] ?? null,
            'country' => $participant['country'] ?? null,
            'designation' => $participant['designation'] ?? null,
            'email' => $participant['email'] ?? null,
            'country_code_mobile' => $participant['country_code_mobile'] ?? null,
            'mobile_no' => $participant['mobile_no'] ?? null,
            'addtnl_type' => $participant['addtnl_type'] ?? null,
            'senior' => $participant['senior'] == 'yes' ? 1 : 0,
            'pwd' => $participant['pwd'] == 'yes' ? 1 : 0,
            'id_file' => $fileName
        ]);
        
        $conference->conferenceDelegates()->save($confDelegate);

        return response()->json(['pid' => $confDelegate->id], 200);
    }

    public function deleteConferenceParticipant(Request $request) {
        $participant_id = $request->input('p_id');

        $confDelegate = SSXConferenceDelegate::find($participant_id);

        if(!$confDelegate){
            return response()->json(['error' => 'Not found'], 404);
        }

        $confDelegate->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function storeConferenceRegistration(Request $request){

        $reg_no = $this->generateRegistrationNumber();
        // $breakdown = json_decode($request->input('breakdown'), true) ?? [];
        // $step1 = json_decode($request->input('step1'), true) ?? [];
        $conf_id = $request->input('conf_id');
        $step2 = json_decode($request->input('step2'), true) ?? [];
        $step3 = json_decode($request->input('step3'), true) ?? [];
        
        $conference = SSXConference::find($conf_id);

        if(!$conference) {
            return response()->json(['error' => 'Not found'], 404);
        }
        
        $conference->registration_number = $reg_no;
        $conference->fair_code = 'SSX2026';
        $conference->company_name = $step3['company_name'];
        $conference->company_address = $step3['company_address'];
        $conference->tin = $step3['tin'];
        $conference->contact_person = $step3['contact_person'];
        $conference->company_email = $step3['company_email'];
        $conference->contact_number = $step3['contact_number'];
        $conference->dietary = $step2['dietary'];
        $conference->dietary_details = $step2['dietary_details'];
        $conference->certificate = $step2['certificate'];
        $conference->promotional_email = $step2['promotional_email'];
        $conference->status = 2;
        $conference->update();

        $billing_fileName = $this->generateBillingPDF($conf_id);
        $conference->billing_file = $billing_fileName;
        $conference->update();

        // if (!empty($breakdown) && is_array($breakdown)) {
            
        //     foreach ($breakdown as $entry) {
        //         $confBreakdown = new SSXConferenceBreakdown;
        //         $confBreakdown->code = $entry['code'] ?? null;
        //         $confBreakdown->type = $entry['entry_type'] ?? null;
        //         $confBreakdown->value = $entry['computed'] ?? null;
        //         $confBreakdown->description = $entry['desc'] ?? null;
        //         $conference->conferenceBreakdown()->save($confBreakdown);
        //     }
        // }

        // if (!empty($step1['participants']) && is_array($step1['participants'])) {
        //     foreach ($step1['participants'] as $entry) {
        //         $confDelegate = new SSXConferenceDelegate;
        //         $confDelegate->salutation = $entry['salutation'] ?? null;
        //         $confDelegate->fname = $entry['fname'] ?? null;
        //         $confDelegate->lname = $entry['lname'] ?? null;
        //         $confDelegate->country = $entry['country'] ?? null;
        //         $confDelegate->designation = $entry['designation'] ?? null;
        //         $confDelegate->email = $entry['email'] ?? null;
        //         $confDelegate->country_code_mobile = $entry['country_code_mobile'] ?? null;
        //         $confDelegate->mobile_no = $entry['mobile_no'] ?? null;
        //         $conference->conferenceDelegates()->save($confDelegate);
        //     }
        // }

        if (!empty($step2['knowHow']) && is_array($step2['knowHow'])) {
            foreach ($step2['knowHow'] as $entry) {
                $confKnowHow = new SSXConferenceKnowhow;
                $confKnowHow->value = $entry;
                $conference->conferenceKnowhow()->save($confKnowHow);
            }
        }

        $billing_statment = env('APP_URL') . '/conference/billing/' . $conference->billing_file;

        if (env('APP_ENV') != 'local') {
            Mail::to(strtolower($conference->company_email))->bcc(['kgtecson.citem@gmail.com','kenneth.tecson07@gmail.com'])->send(new CompleteConferenceRegistration($billing_statment));
        } else {
            Mail::to('nogidlayan@citem.com.ph')->send(new CompleteConferenceRegistration($billing_statment));
        }


        
        return response()->json(['reg_no' => $reg_no], 200);

    }
}
