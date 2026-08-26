<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorsSuppliersSalesInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class SalesInquiriesController extends Controller
{
    private function getLatestFairCode(): ?string
{
    $fairCode = Event::latest('id')->value('fair_code');

    if (!$fairCode) {
        throw new Exception('No active event found.');
    }

    return $fairCode;
}
     public function index()
    {
           $supplier_id  = Auth::guard('supplier')->user();
        return view('supplier.daily_sales_report.inquiries.index', compact('supplier_id'));
    }


        public function create(Request $request){
      $supplier_id  = Auth::guard('supplier')->user();
        return view('supplier.daily_sales_report.inquiries.create', compact('supplier_id'));
    }

public function edit($id)
{
    $supplier_id = Auth::guard('supplier')->user();

    $inquiry = ExhibitorsSuppliersSalesInquiry::with([
        'event:id,fair_code,event_name',
    ])
    ->where('id', $id)
    ->where('ff_code', $supplier_id->id)
    ->firstOrFail();

    return view('supplier.daily_sales_report.inquiries.edit',
        compact('supplier_id', 'inquiry')
    );
}

public function store(Request $request)
{
    $supplier = Auth::guard('supplier')->user();

    $validated = $request->validate([
        'date_of_sale' => ['required', 'date'],
        'no_of_inquiries' => ['required', 'integer', 'min:0'],
        'no_of_buyers_met' => ['required', 'integer', 'min:0'],
    ]);

    $inquiry = ExhibitorsSuppliersSalesInquiry::create([
        'ff_code' => $supplier->id,
        'fair_code' => $this->getLatestFairCode(),
        'date_of_sale' => $validated['date_of_sale'],
        'no_of_inquiries' => $validated['no_of_inquiries'],
        'no_of_buyers_met' => $validated['no_of_buyers_met'],
    ]);

    return response()->json([
        'message' => 'Sales inquiry created successfully.',
        'data' => $inquiry
    ], 201);
}

public function show($id)
{
    $supplier = Auth::guard('supplier')->user();

    $inquiry = ExhibitorsSuppliersSalesInquiry::where('id', $id)
        ->where('ff_code', $supplier->id)
        ->firstOrFail();

    return response()->json([
        'data' => $inquiry
    ]);
}

public function update(Request $request, $id)
{
    $request->validate([
        'date_of_sale' => 'required|date',
        'no_of_inquiries' => 'required|integer|min:0',
        'no_of_buyers_met' => 'required|integer|min:0',
    ]);

    $supplier = Auth::guard('supplier')->user();

    $inquiry = ExhibitorsSuppliersSalesInquiry::where('id', $id)
        ->where('ff_code', $supplier->id)
        ->firstOrFail();

    $inquiry->update([
        'date_of_sale' => $request->date_of_sale,
        'no_of_inquiries' => $request->no_of_inquiries,
        'no_of_buyers_met' => $request->no_of_buyers_met,
    ]);

    return response()->json([
        'message' => 'Inquiry updated successfully',
        'data' => $inquiry
    ]);
}

public function destroy($id)
{
    $supplier = Auth::guard('supplier')->user();

    $inquiry = ExhibitorsSuppliersSalesInquiry::where('id', $id)
        ->where('ff_code', $supplier->id)
        ->firstOrFail();

    try {
        $inquiry->delete();

        return response()->json([
            'message' => 'Inquiry deleted successfully',
        ]);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Failed to delete inquiry',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function inquiries_index(Request $request)
{
    $per_page = (int) $request->input('per_page', 10);
    $page = (int) $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $baseQuery = ExhibitorsSuppliersSalesInquiry::query()
        ->with([
            'event:id,fair_code,event_name',
        ]);

    if (!empty($request->supplier_id)) {
        $baseQuery->where('ff_code', $request->supplier_id);
    }

    $total = (clone $baseQuery)->count();

    $records = $baseQuery
        ->offset($offset)
        ->limit($per_page)
        ->latest()
        ->get()
        ->map(function ($item) {

            return [
                'id' => $item->id,
                'fair_code' => $item->fair_code,
                'date_of_sale' => $item->date_of_sale,
                'no_of_inquiries' => $item->no_of_inquiries,
                'no_of_buyers_met' => $item->no_of_buyers_met,
            ];
        });

    return response()->json([
        'total' => $total,
        'data' => $records,
    ], 200);
    }

    

}
