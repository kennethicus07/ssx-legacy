<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buyer\BuyerAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Category;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorAttendance;
use Artisan;

class ApiController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function delete_image(Request $request)
    {
        $result = DB::table($request->input('table'))->where('id', $request->input('id'))->first();
        if (!empty($result)) {
            DB::table($request->input('table'))->where('id', $request->input('id'))->update([
                "{$request->input('field')}" => NULL
            ]);
            @unlink("{$request->input('path')}");
            if (!empty($request->input('path1'))) {
                @unlink("{$request->input('path1')}");
            }
        }
        return response()->json(true, 200);
    }

    public function wysiwyg_image_upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $image_path = $request->file('file')->store('public/widgets', 'local');
            //echo url($image_path);
            return response()->json(['status' => 200, 'location' => Storage::url($image_path)], 200);
        } else {
            header("HTTP/1.1 500 Server Error");
        }
    }

    public function clear_cache()
    {
        Artisan::call('cache:clear');
        return response()->json(true, 200);
    }

    public function clear_view()
    {
        Artisan::call('view:clear');
        return response()->json(true, 200);
    }

    public function clear_route()
    {
        Artisan::call('route:clear');
        return response()->json(true, 200);
    }

    public function clear_config()
    {
        Artisan::call('config:clear');
        return response()->json(true, 200);
    }

    public function cache_config()
    {
        Artisan::call('config:cache');
        return response()->json(true, 200);
    }

    public function cache_route()
    {
        Artisan::call('route:cache');
        return response()->json(true, 200);
    }

    public function cache_view()
    {
        Artisan::call('view:cache');
        return response()->json(true, 200);
    }

    public function suppliers_summary()
    {
        $user_status = DB::table('users')->select(DB::raw('count(status) as user_status_count, status'))->where('user_group', 2)->groupBy('status')->get();
        $arr_status = [];
        $approved = 0;
        $denied = 0;
        $onhold = 0;
        $incomplete = 0;
        $pending = 0;
        $reviewed = 0;
        $total_registered = 0;
        //0 = Incomplete, 1 = Approved, 2 = Pending, 3 = Reviewed, 4 = Onhold 5 = Disapproved
        foreach ($user_status as $status) {
            if ($status->status === 1) {
                $approved = number_format($status->user_status_count);
            } 
            if ($status->status === 2) {
                $pending = number_format($status->user_status_count);
            } 
            if ($status->status === 3) {
                $reviewed = number_format($status->user_status_count);
            } 
            if ($status->status === 4) {
                $onhold = number_format($status->user_status_count);
            } 
            if ($status->status === 5) {
                $denied = number_format($status->user_status_count);
            } 
            if ($status->status === 0) {
                $incomplete = number_format($status->user_status_count);
            }
        }
        $total_registered = ($approved + $denied + $pending + $reviewed + $onhold + $incomplete);
        $arr_status = [
            'approved' => $approved,
            'denied' => $denied,
            'pending' => $pending,
            'reviewed' => $reviewed,
            'onhold' => $onhold,
            'incomplete' => $incomplete,
            'total_registered' => number_format($total_registered)
        ];
        return response()->json($arr_status, 200);
    }

    public function purchaser_summary()
    {
        $user_status = DB::table('users')->select(DB::raw('count(status) as user_status_count, status'))->where('user_group', 3)->groupBy('status')->get();
        $arr_status = [];
        $approved = 0;
        $denied = 0;
        $onhold = 0;
        $incomplete = 0;
        $pending = 0;
        $reviewed = 0;
        $total_registered = 0;
        //0 = Incomplete, 1 = Approved, 2 = Pending, 3 = Reviewed, 4 = Onhold 5 = Disapproved
        foreach ($user_status as $status) {
            if ($status->status === 1) {
                $approved = number_format($status->user_status_count);
            } 
            if ($status->status === 2) {
                $pending = number_format($status->user_status_count);
            } 
            if ($status->status === 3) {
                $reviewed = number_format($status->user_status_count);
            } 
            if ($status->status === 4) {
                $onhold = number_format($status->user_status_count);
            } 
            if ($status->status === 5) {
                $denied = number_format($status->user_status_count);
            } 
            if ($status->status === 0) {
                $incomplete = number_format($status->user_status_count);
            }
        }
        $total_registered = ($approved + $denied + $pending + $reviewed + $onhold + $incomplete);
        $arr_status = [
            'approved' => $approved,
            'denied' => $denied,
            'pending' => $pending,
            'reviewed' => $reviewed,
            'onhold' => $onhold,
            'incomplete' => $incomplete,
            'total_registered' => number_format($total_registered)
        ];
        return response()->json($arr_status, 200);
    }

    // ! For Fair 

  public function suppliers_summary_fair()
{
    // Get latest event
    $event = Event::latest('created_at')->first();

    if (! $event) {
        return response()->json([
            'approved' => 0,
            'conforme_pending_generation' => 0,
            'denied' => 0,
            'pending' => 0,
            'reviewed' => 0,
            'onhold' => 0,
            'incomplete' => 0,
            'total_registered' => 0,
        ]);
    }

    $fairCode = $event->fair_code;

    $baseQuery = ExhibitorAttendance::where('fair_code', $fairCode);

    $approved = (clone $baseQuery)
        ->where('status', 1)
        ->where('conforme_review', 1)
        ->count();

    $conformePending = (clone $baseQuery)
        ->where('status', 1)
        ->where(function ($q) {
            $q->whereNull('conforme_review')
              ->orWhere('conforme_review', 0);
        })
        ->count();

    $denied = (clone $baseQuery)->where('status', 5)->count();
    $pending = (clone $baseQuery)->where('status', 2)->count();
    $reviewed = (clone $baseQuery)->where('status', 3)->count();
    $onhold = (clone $baseQuery)->where('status', 4)->count();
    $incomplete = (clone $baseQuery)->where('status', 0)->count();

    $totalRegistered = (clone $baseQuery)->count();

    return response()->json([
        'approved'                     => number_format($approved),
        'conforme_pending_generation'    => number_format($conformePending),
        'denied'                       => number_format($denied),
        'pending'                      => number_format($pending),
        'reviewed'                     => number_format($reviewed),
        'onhold'                       => number_format($onhold),
        'incomplete'                   => number_format($incomplete),
        'total_registered'             => number_format($totalRegistered),
        'fair_code'                    => $fairCode,
    ], 200);
}

   public function purchaser_summary_fair()
{
    // Get latest event
    $event = Event::latest('created_at')->first();

    if (! $event) {
        return response()->json([
            'approved' => 0,
            'denied' => 0,
            'pending' => 0,
            'reviewed' => 0,
            'onhold' => 0,
            'incomplete' => 0,
            'total_registered' => 0,
        ], 200);
    }

    $fairCode = $event->fair_code;

    $baseQuery = BuyerAttendance::where('fair_code', $fairCode);

    $approved   = (clone $baseQuery)->where('status', 1)->count();
    $pending    = (clone $baseQuery)->where('status', 2)->count();
    $reviewed   = (clone $baseQuery)->where('status', 3)->count();
    $onhold     = (clone $baseQuery)->where('status', 4)->count();
    $denied     = (clone $baseQuery)->where('status', 5)->count();
    $incomplete = (clone $baseQuery)->where('status', 0)->count();

    $totalRegistered = (clone $baseQuery)->count();

    return response()->json([
        'approved'         => number_format($approved),
        'denied'           => number_format($denied),
        'pending'          => number_format($pending),
        'reviewed'         => number_format($reviewed),
        'onhold'           => number_format($onhold),
        'incomplete'       => number_format($incomplete),
        'total_registered' => number_format($totalRegistered),
        'fair_code'        => $fairCode,
    ], 200);
}
}
