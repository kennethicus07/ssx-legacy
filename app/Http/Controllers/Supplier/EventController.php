<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorAttendance;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('supplier.events.index', compact('events'));
    }

public function getEventsForSupplier()
{
    $supplier = Auth::guard('supplier')->user();
    $userId = $supplier ? $supplier->id : null;

    $events = Event::latest()->get();

    // Attach exhibitor attendance status
    foreach ($events as $event) {
    $attendance = ExhibitorAttendance::where('user_id', $userId)
        ->where('fair_code', $event->fair_code)
        ->first();

    $event->attendance_status = $attendance->status ?? null;
    $event->conforme_review = $attendance->conforme_review ?? 0;
}

    return response()->json($events);
}

   public function getEvents()
    {
        return response()->json(
            Event::latest()->get()
        );
    }

    

           public function event_payments_list()
    {
           $supplier_id  = Auth::guard('supplier')->user();
        return view('supplier.payments.events.list', compact('supplier_id'));
    }


public function viewEventPayment($slug)
{
    $supplier = Auth::guard('supplier')->user();

    // Get the event
    $event = Event::where('slug', $slug)->firstOrFail();

    // Get the attendance
    $attendance = ExhibitorAttendance::where('user_id', $supplier->id)
        ->where('fair_code', $event->fair_code)
        ->first();

    // Restrict access if attendance doesn't exist or SOA not generated
    if (!$attendance || !$attendance->is_soa_generated) {
        return redirect()->route('supplier.payments.events.index');
       
    }

    return view('supplier.payments.events.view', compact('attendance', 'event'));
}
    
}
