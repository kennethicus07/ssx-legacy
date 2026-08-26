<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Event;
use App\Models\Supplier\ExhibitorsSuppliersSalesInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Exports\SalesInquiriesExport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

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
       
        return view('admin.daily_sales_report.inquiries.index');
    }





public function inquiries_index(Request $request)
{
    $per_page = (int) $request->input('per_page', 10);
    $page = (int) $request->input('page', 1);
    $offset = ($page - 1) * $per_page;

    $baseQuery = ExhibitorsSuppliersSalesInquiry::query()
        ->with([
            'event:id,fair_code,event_name',
            'user:id,name',
        ]);

    /*
    |--------------------------------------------------------------------------
    | FILTERS
    |--------------------------------------------------------------------------
    */

    if ($request->has('filter')) {

        $filters = json_decode($request->input('filter'), true);

        if (!empty($filters['date_of_sale'])) {

            $baseQuery->whereDate(
                'date_of_sale',
                $filters['date_of_sale']
            );
        }

        if (!empty($filters['supplier_name'])) {

            $baseQuery->whereHas('user', function ($query) use ($filters) {

                $query->where(
                    'name',
                    'like',
                    '%' . $filters['supplier_name'] . '%'
                );
            });
        }

        if (!empty($filters['fair_code'])) {

            $baseQuery->where(
                'fair_code',
                $filters['fair_code']
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SORTING
    |--------------------------------------------------------------------------
    */

    if ($request->has('sort')) {

        $sort = json_decode($request->input('sort'), true);

        if (!empty($sort['field'])) {

            $direction = $sort['type'] ?? 'desc';

            $allowedSorts = [
                'created_at',
                'date_of_sale',
                'no_of_inquiries',
                'no_of_buyers_met',
            ];

            if (in_array($sort['field'], $allowedSorts)) {

                $baseQuery->orderBy(
                    $sort['field'],
                    $direction
                );
            }
        }
    } else {

        $baseQuery->latest();
    }

    $total = (clone $baseQuery)->count();

    $records = $baseQuery
        ->offset($offset)
        ->limit($per_page)
        ->get()
        ->map(function ($item) {

            return [
                'id' => $item->id,
                'fair_code' => $item->fair_code,
                'event_name' => $item->event->event_name ?? '-',
                'supplier_name' => $item->user->name ?? '-',
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

    public function export(Request $request)
{
    $baseQuery = ExhibitorsSuppliersSalesInquiry::query()
        ->with([
            'event:id,fair_code,event_name',
            'user:id,name',
        ]);

    if ($request->has('filter')) {

        $filters = json_decode($request->input('filter'), true);

        if (!empty($filters['date_of_sale'])) {
            $baseQuery->whereDate(
                'date_of_sale',
                $filters['date_of_sale']
            );
        }

        if (!empty($filters['supplier_name'])) {
            $baseQuery->whereHas('user', function ($query) use ($filters) {
                $query->where(
                    'name',
                    'like',
                    '%' . $filters['supplier_name'] . '%'
                );
            });
        }

        if (!empty($filters['fair_code'])) {
            $baseQuery->where(
                'fair_code',
                $filters['fair_code']
            );
        }
    }

    $rows = $baseQuery
        ->get()
        ->map(function ($item) {

            return [
                $item->fair_code,
                $item->event->event_name ?? '-',
                $item->user->name ?? '-',
                Carbon::parse($item->date_of_sale)->format('M d, Y'),
                $item->no_of_inquiries,
                $item->no_of_buyers_met,
            ];
        })
        ->toArray();

    return Excel::download(
        new SalesInquiriesExport($rows),
        'sales-inquiries.xlsx'
    );
}

}
