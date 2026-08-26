<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorsSuppliersSale;
use App\Models\Supplier\ExhibitorsSuppliersSalesInquiry;
use App\Models\Supplier\ExhibitorAttendance;
use App\Models\Supplier\Event;
use App\Models\User;
use App\Enums\SalesTypeStatus;
use Carbon\Carbon;

class SalesManagementController extends Controller
{
    public function index()
    {
        return view('admin.daily_sales_report.sales_management.index');
    }

    public function salesManagementSuppliers(Request $request)
{
    $fairCode = $request->fair_code;

    $query = ExhibitorAttendance::query()
        ->with([
            'user:id,name,email',
            'exhibitor:id,uid,co_name,fair_code',
        ])
        ->whereHas('exhibitor');

   

    if (!empty($fairCode)) {
        $query->where('fair_code', $fairCode);
    }

    $suppliers = $query
        ->get()
        ->unique('user_id')
        ->map(function ($attendance) {

            return [
                'user_id' => $attendance->user_id,

                'company' => optional(
                    $attendance->exhibitor
                )->co_name,

                'fair_code' => $attendance->fair_code,

                'user_name' => optional(
                    $attendance->user
                )->name,
            ];
        })
        ->values();

    return response()->json($suppliers);
}
public function salesManagement(
    Request $request,
    User $user
) {

    $fairCode = $request->query('fair_code');

    // fair_code required
    if (!$fairCode) {
        abort(404);
    }

    $event = Event::where(
        'fair_code',
        $fairCode
    )->first();

    // invalid fair code
    if (!$event) {
        abort(404);
    }

    $exhibitor = $user->exhibitor()
        ->where('fair_code', $fairCode)
        ->first();

    // user not registered to this fair
    if (!$exhibitor) {
        abort(404);
    }

    return view(
        'admin.daily_sales_report.sales_management.show',
        [
            'user' => $user,
            'event' => $event,
            'fairCode' => $fairCode,
            'exhibitor' => $exhibitor,
        ]
    );
}


   public function salesList(
        Request $request,
        int $sales_type
    ) {

        $allowedSalesTypes = [
            SalesTypeStatus::EXPORT,
            SalesTypeStatus::DOMESTIC,
            SalesTypeStatus::RETAIL,
        ];

        if (!in_array($sales_type, $allowedSalesTypes)) {

            return response()->json([
                'message' => 'Invalid sales type.',
            ], 422);
        }

        $records = ExhibitorsSuppliersSale::query()
            ->with([
                'sub_category_all:id,name',
                'country:id,name',
            ])
            ->where('sales_type', $sales_type)
            ->where('ff_code', $request->ff_code)
            ->where('fair_code', $request->fair_code)
            ->latest()
            ->get()
->map(function ($sale) {

    return [
        'id' => $sale->id,

        'sales_type' => $sale->sales_type,

        'sales_type_label' =>
            SalesTypeStatus::label(
                $sale->sales_type
            ),

        'date_of_sale' =>
            $sale->date_of_sale,

  
        'sub_category_id' =>
            $sale->sub_category_id,

        'country_destination' =>
            $sale->country_destination,

        'product_service_name' =>
            $sale->sub_category_all->name ?? '-',

   
        'buyer_company' =>
            $sale->co_buyer_name,

        'co_buyer_name' =>
            $sale->co_buyer_name,

        'type_of_purchaser_buyer' =>
            $sale->type_of_purchaser_buyer,

        'country' =>
            $sale->country,

        'booked' =>
            $sale->booked,

        'under_negotiation' =>
            $sale->under_negotiation,
    ];
});

        return response()->json($records, 200);
    }

       public function storeSales(Request $request)
    {

        $sale = ExhibitorsSuppliersSale::create([

            'ff_code' => $request->ff_code,

            'fair_code' => $request->fair_code,

            'sales_type' => $request->sales_type,

            'date_of_sale' => $request->date_of_sale,

            'sub_category_id' => $request->sub_category_id,

            'co_buyer_name' => $request->buyer_company,

            'country_destination' =>
                $request->country_destination,

            'type_of_purchaser_buyer' =>
                $request->type_of_purchaser_buyer,

            'booked' => $request->booked,

            'under_negotiation' =>
                $request->under_negotiation,
        ]);

        return response()->json([
            'message' => 'Sales saved successfully.',
            'data' => $sale,
        ], 201);
    }

    public function update(
    Request $request,
    int $id
) {

    $sale = ExhibitorsSuppliersSale::find($id);

    if (!$sale) {

        return response()->json([
            'message' => 'Sale not found.',
        ], 404);
    }

    $sale->update([
        'ff_code' => $request->ff_code,

        'fair_code' => $request->fair_code,

        'sales_type' => $request->sales_type,

        'date_of_sale' => $request->date_of_sale,

        'sub_category_id' => $request->sub_category_id,

        'co_buyer_name' => $request->buyer_company,

        'country_destination' =>
            $request->country_destination,

        'booked' => $request->booked,

        'under_negotiation' =>
            $request->under_negotiation,

        'type_of_purchaser_buyer' =>
            $request->type_of_purchaser_buyer,
    ]);

    return response()->json([
        'message' => 'Sale updated successfully.',
        'data' => $sale,
    ], 200);
}

    public function deleteSale($id)
{
    $sale = ExhibitorsSuppliersSale::findOrFail($id);

    $sale->delete();

    return response()->json([
        'success' => true,
        'message' => 'Sale deleted successfully.',
    ], 200);
}


public function inquiriesList(
    Request $request
) {

    $records = ExhibitorsSuppliersSalesInquiry::query()
        ->where('ff_code', $request->ff_code)
        ->where('fair_code', $request->fair_code)
        ->latest()
        ->get()
        ->map(function ($inquiry) {

            return [
                'id' => $inquiry->id,

                'inquiries_date_of_sale' =>
                    $inquiry->date_of_sale,

                'no_of_inquiries' =>
                    $inquiry->no_of_inquiries,

                'no_of_buyers_met' =>
                    $inquiry->no_of_buyers_met,
            ];
        });

    return response()->json($records, 200);
}

public function storeInquiry(
    Request $request
) {

    $record = ExhibitorsSuppliersSalesInquiry::create([
        'ff_code' => $request->ff_code,
        'fair_code' => $request->fair_code,
        'date_of_sale' =>
            $request->inquiries_date_of_sale,
        'no_of_inquiries' =>
            $request->no_of_inquiries,
        'no_of_buyers_met' =>
            $request->no_of_buyers_met,
    ]);

    return response()->json([
        'message' => 'Inquiry saved successfully.',
        'data' => $record,
    ], 201);
}

public function deleteInquiry(
    int $id
) {

    $record = ExhibitorsSuppliersSalesInquiry::find($id);

    if (!$record) {

        return response()->json([
            'message' => 'Inquiry not found.',
        ], 404);
    }

    $record->delete();

    return response()->json([
        'message' => 'Inquiry deleted successfully.',
    ], 200);
}

public function updateInquiry(
    Request $request,
    int $id
) {

    $record = ExhibitorsSuppliersSalesInquiry::find($id);

    if (!$record) {

        return response()->json([
            'message' => 'Inquiry not found.',
        ], 404);
    }

    $record->update([
        'ff_code' => $request->ff_code,

        'fair_code' => $request->fair_code,

        'date_of_sale' =>
            $request->inquiries_date_of_sale,

        'no_of_inquiries' =>
            $request->no_of_inquiries,

        'no_of_buyers_met' =>
            $request->no_of_buyers_met,
    ]);

    return response()->json([
        'message' => 'Inquiry updated successfully.',
        'data' => $record,
    ], 200);
}

}