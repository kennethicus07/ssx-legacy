<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorsSuppliersSale;
use App\Enums\SalesTypeStatus;
use App\Models\Supplier\Event;
use App\Exports\RetailSalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Carbon;

class RetailSalesController extends Controller
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
        return view('admin.daily_sales_report.retail_sales.index');
    }

    public function retail_sales_index(Request $request)
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
            ->where('sales_type', SalesTypeStatus::RETAIL);

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

            if (!empty($filters['co_buyer_name'])) {
                $baseQuery->where(
                    'co_buyer_name',
                    'like',
                    '%' . $filters['co_buyer_name'] . '%'
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

            if (!empty($filters['type_of_purchaser_buyer'])) {
                $baseQuery->where(
                    'type_of_purchaser_buyer',
                    'like',
                    '%' . $filters['type_of_purchaser_buyer'] . '%'
                );
            }

            if (
                !empty($filters['sub_category_ids']) &&
                is_array($filters['sub_category_ids'])
            ) {
                $baseQuery->whereIn(
                    'sub_category_id',
                    $filters['sub_category_ids']
                );
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
                    'booked',
                ];

                if (in_array($sort['field'], $allowedSorts)) {
                    $baseQuery->orderBy($sort['field'], $direction);
                }
            }
        } else {
            $baseQuery->latest();
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
                    'event_name' => $sale->event->event_name ?? '-',
                    'supplier_name' => $sale->user->name ?? '-',
                    'co_buyer_name' => $sale->co_buyer_name,
                    'type_of_purchaser_buyer' =>
                        $sale->type_of_purchaser_buyer,
                    'booked' => $sale->booked,
                    'date_of_sale' => $sale->date_of_sale,
                    'product_service_name' =>
                        $sale->sub_category_all->name ?? '-',
                ];
            });

        return response()->json([
            'total' => $total_sales,
            'data' => $records,
        ], 200);
    }

    public function export(Request $request)
{
    $baseQuery = ExhibitorsSuppliersSale::query()
        ->with([
            'sub_category_all:id,name',
            'user:id,name',
            'event:id,fair_code,event_name',
        ])
        ->where('sales_type', SalesTypeStatus::RETAIL);

    if ($request->has('filter')) {

        $filters = json_decode(
            $request->input('filter'),
            true
        );

        if (!empty($filters['date_of_sale'])) {
            $baseQuery->whereDate(
                'date_of_sale',
                $filters['date_of_sale']
            );
        }

        if (!empty($filters['co_buyer_name'])) {
            $baseQuery->where(
                'co_buyer_name',
                'like',
                '%' . $filters['co_buyer_name'] . '%'
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

        if (!empty($filters['type_of_purchaser_buyer'])) {
            $baseQuery->where(
                'type_of_purchaser_buyer',
                'like',
                '%' . $filters['type_of_purchaser_buyer'] . '%'
            );
        }

        if (
            !empty($filters['sub_category_ids']) &&
            is_array($filters['sub_category_ids'])
        ) {
            $baseQuery->whereIn(
                'sub_category_id',
                $filters['sub_category_ids']
            );
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
        ->map(function ($sale) {

            return [
                $sale->fair_code,
                $sale->event->event_name ?? '-',
                $sale->user->name ?? '-',
                $sale->co_buyer_name,
                $sale->type_of_purchaser_buyer,
                $sale->sub_category_all->name ?? '-',
                $sale->booked,
                Carbon::parse($sale->date_of_sale)->format('M d, Y'),
             
            ];
        })
        ->toArray();

    return Excel::download(
        new RetailSalesExport($rows),
        'retail-sales.xlsx'
    );
}


}