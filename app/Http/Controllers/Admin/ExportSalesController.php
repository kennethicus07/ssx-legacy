<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorsSuppliersSale;
use App\Models\SubCategory;
use App\Enums\SalesTypeStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier\Event;
use Exception;
use App\Exports\ExportSalesExport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;


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
      
        return view('admin.daily_sales_report.export_sales.index');
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


if ($request->has('filter')) {

    $filters = json_decode($request->input('filter'), true);

    if (!empty($filters['country_destination'])) {
        $baseQuery->where(
            'country_destination',
            $filters['country_destination']
        );
    }

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

    
        if ($request->has('sort')) {

            $sort = json_decode($request->input('sort'), true);

            if (!empty($sort['field'])) {

                $direction = $sort['type'] ?? 'desc';

                $allowedSorts = [
                    'created_at',
                    'date_of_sale',
                    'booked',
                    'under_negotiation',
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
                    'co_buyer_name' => $sale->co_buyer_name,
                    'booked' => $sale->booked,
                    'under_negotiation' => $sale->under_negotiation,
                    'date_of_sale' => $sale->date_of_sale,
                    'product_service_name' =>
                        $sale->sub_category_all->name ?? '-',
                    'country' => $sale->country,
                    'supplier_name' => $sale->user->name ?? '-',
                ];
            });

        return response()->json([
            'total' => $total_sales,
            'data' => $records,
        ], 200);
    }

    public function export(Request $request)
{
    $query = ExhibitorsSuppliersSale::query()
        ->with([
            'sub_category_all:id,name',
            'user:id,name',
            'country:id,name',
            'event:id,fair_code,event_name',
        ])
        ->where('sales_type', SalesTypeStatus::EXPORT);

    if ($request->has('filter')) {

        $filters = $request->input('filter');

        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        if (!empty($filters['country_destination'])) {
            $query->where(
                'country_destination',
                $filters['country_destination']
            );
        }

        if (!empty($filters['date_of_sale'])) {
            $query->whereDate(
                'date_of_sale',
                $filters['date_of_sale']
            );
        }

        if (!empty($filters['co_buyer_name'])) {
            $query->where(
                'co_buyer_name',
                'like',
                '%' . $filters['co_buyer_name'] . '%'
            );
        }

        if (!empty($filters['supplier_name'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where(
                    'name',
                    'like',
                    '%' . $filters['supplier_name'] . '%'
                );
            });
        }

        if (
            !empty($filters['sub_category_ids']) &&
            is_array($filters['sub_category_ids'])
        ) {
            $query->whereIn(
                'sub_category_id',
                $filters['sub_category_ids']
            );
        }

        if (!empty($filters['fair_code'])) {
            $query->where(
                'fair_code',
                $filters['fair_code']
            );
        }
    }

    $rows = $query->get()->map(function ($sale) {

        return [
            'fair_code' => $sale->fair_code,
            'event_name' => $sale->event->event_name ?? '-',
            'supplier_name' => $sale->user->name ?? '-',
            'buyer_company' => $sale->co_buyer_name,
            'product_service' => $sale->sub_category_all->name ?? '-',
            'country' => optional($sale->country)->name,
            'booked' => $sale->booked,
            'under_negotiation' => $sale->under_negotiation,
            'date_of_sale' => Carbon::parse($sale->date_of_sale)->format('M d, Y'),
        ];
    })->toArray();

    return Excel::download(
        new ExportSalesExport($rows),
        'export-sales.xlsx'
    );
}

}
