<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorsSuppliersSale;
use App\Models\SubCategory;
use App\Enums\SalesTypeStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier\Event;
use Exception;

class ExportSalesController extends Controller
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
        return view('supplier.daily_sales_report.export_sales.index', compact('supplier_id'));
    }

    public function create(Request $request){
      $supplier_id  = Auth::guard('supplier')->user();
        return view('supplier.daily_sales_report.export_sales.create', compact('supplier_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_category_id' => 'required',
            'co_buyer_name' => 'required|string|max:255',
            'country_destination' => 'required|integer',
            'booked' => 'nullable|numeric',
            'under_negotiation' => 'nullable|numeric',
            'date_of_sale' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $supplier = Auth::guard('supplier')->user();

        $sale = ExhibitorsSuppliersSale::create([
            'fair_code' => $this->getLatestFairCode(), 
            'ff_code' => $supplier->id,
            'sub_category_id' => $request->sub_category_id,
            'co_buyer_name' => $request->co_buyer_name,
            'country_destination' => $request->country_destination,
            'booked' => $request->booked ?? 0,
            'under_negotiation' => $request->under_negotiation ?? 0,
            'date_of_sale' => $request->date_of_sale,
            'remarks' => $request->remarks,
            'sales_type' => SalesTypeStatus::EXPORT,
        ]);

        return response()->json([
            'message' => 'Export sale created successfully',
            'data' => $sale
        ]);
    }

    public function edit($id)
    {
        $supplier_id = Auth::guard('supplier')->user();

        $sale = ExhibitorsSuppliersSale::with([
            'country',
            'event',
            'sub_category_all',
        ])->where('id', $id)->where('ff_code', $supplier_id->id)->firstOrFail();

        return view( 'supplier.daily_sales_report.export_sales.edit',
            compact('supplier_id', 'sale')
        );
    }

    public function show($id)
    {
        $sale = ExhibitorsSuppliersSale::with([
            'country',
            'event',
            'sub_category_all',
        ])->findOrFail($id);

        return response()->json([
            'data' => $sale
        ]);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'sub_category_id' => 'required',
        'co_buyer_name' => 'required|string|max:255',
        'country_destination' => 'required|integer',
        'booked' => 'nullable|numeric',
        'under_negotiation' => 'nullable|numeric',
        'date_of_sale' => 'required|date',
        'remarks' => 'nullable|string',
    ]);

    $supplier = Auth::guard('supplier')->user();

    $sale = ExhibitorsSuppliersSale::where('id', $id)
        ->where('ff_code', $supplier->id)
        ->where('sales_type', SalesTypeStatus::EXPORT)
        ->firstOrFail();

    $sale->update([
        'sub_category_id' => $request->sub_category_id,
        'co_buyer_name' => $request->co_buyer_name,
        'country_destination' => $request->country_destination,
        'booked' => $request->booked ?? 0,
        'under_negotiation' => $request->under_negotiation ?? 0,
        'date_of_sale' => $request->date_of_sale,
        'remarks' => $request->remarks,
    ]);

    return response()->json([
        'message' => 'Export sale updated successfully',
        'data' => $sale
    ]);
    }


public function destroy($id)
{
    $supplierId = Auth::guard('supplier')->id();

    $sale = ExhibitorsSuppliersSale::where('id', $id)
        ->where('ff_code', $supplierId)
        ->where('sales_type', SalesTypeStatus::EXPORT)
        ->firstOrFail();

    $sale->delete();

    return response()->json([
        'message' => 'Export sale deleted successfully'
    ]);
}

    public function export_sales_index(Request $request)
    {
        $per_page = (int) $request->input('per_page', 10);
        $page = (int) $request->input('page', 1);
        $offset = ($page - 1) * $per_page;


        $baseQuery = ExhibitorsSuppliersSale::query()
            ->with([
                'sub_category_all:id,name',
                'user:id,name',
                'country:id,name',
                'event:id,fair_code,event_name',
            ])
            ->where('sales_type', SalesTypeStatus::EXPORT);

        
        if (!empty($request->supplier_id)) {
            $baseQuery->where('ff_code', $request->supplier_id);
        }

    
        if ($request->has('filter')) {

            $filters = json_decode($request->input('filter'), true);

            if (!empty($filters['country_destination'])) {
                $baseQuery->where('country_destination', $filters['country_destination']);
            }

            if (!empty($filters['date_of_sale'])) {
                $baseQuery->whereDate('date_of_sale', $filters['date_of_sale']);
            }

            if (!empty($filters['co_buyer_name'])) {
                $baseQuery->where('co_buyer_name', 'like', '%' . $filters['co_buyer_name'] . '%');
            }

            if (!empty($filters['sub_category_ids']) && is_array($filters['sub_category_ids'])) {
                $baseQuery->whereIn('sub_category_id', $filters['sub_category_ids']);
            }
            
            if (!empty($filters['fair_code'])) {
                $baseQuery->where('fair_code', $filters['fair_code']);
            }
        }

    
        $total_sales = (clone $baseQuery)->count();

    
        $records = $baseQuery
            ->offset($offset)
            ->limit($per_page)
            ->get()
            ->map(function ($sale) {

                return [
                    'id' => $sale->id,
                    'fair_code' => $sale->fair_code,
                    'co_buyer_name' => $sale->co_buyer_name,
                    'event_name' => $sale->event->fair_code,
                    'booked' => $sale->booked,
                    'under_negotiation' => $sale->under_negotiation,
                    'date_of_sale' => $sale->date_of_sale,
                    'product_service_name' => $sale->sub_category_all->name ?? '-',
                    'country' => $sale->country,
                ];
            });

        return response()->json([
            'total' => $total_sales,
            'data' => $records,
        ], 200);
    }


}
