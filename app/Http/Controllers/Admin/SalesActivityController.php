<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier\ExhibitorsSuppliersSale;
use App\Models\Supplier\ExhibitorsSuppliersSalesInquiry;
use App\Exports\GeneralSummaryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Enums\SalesTypeStatus;
use App\Exports\GeneralSummaryMultiSheetExport;
use Carbon\Carbon;

class SalesActivityController extends Controller
{

    private function getActivityData(Request $request)
    {
        $response = $this->sales_activity_index($request);

        $content = json_decode(
            $response->getContent(),
            true
        );

        return $content['data'] ?? [];
    } 

    public function index()
    {
        return view('admin.daily_sales_report.sales_activity.index');
    }

    


public function sales_activity_index(Request $request)
{
    $per_page = (int) $request->input('per_page', 10);

    $page = (int) $request->input('page', 1);

 $filters = $request->input('filter', []);

if (is_string($filters)) {
    $filters = json_decode($filters, true);
}

$filters = $filters ?? [];

    /*
    |--------------------------------------------------------------------------
    | FAIR CODE FILTER
    |--------------------------------------------------------------------------
    */

    $fairCode = $filters['fair_code'] ?? null;

    /*
    |--------------------------------------------------------------------------
    | EXPORT SALES
    |--------------------------------------------------------------------------
    */

    $exportQuery = ExhibitorsSuppliersSale::query()
        ->with([
            'sub_category_all:id,name',
            'country:id,name',
            'exhibitor:id,uid,co_name',
        ])
        ->where('sales_type', SalesTypeStatus::EXPORT);

    if (!empty($fairCode)) {
        $exportQuery->where('fair_code', $fairCode);
    }

    $exportSales = $exportQuery->get();

    /*
    |--------------------------------------------------------------------------
    | DOMESTIC SALES
    |--------------------------------------------------------------------------
    */

    $domesticQuery = ExhibitorsSuppliersSale::query()
        ->with([
            'sub_category_all:id,name',
            'exhibitor:id,uid,co_name',
        ])
        ->where('sales_type', SalesTypeStatus::DOMESTIC);

    if (!empty($fairCode)) {
        $domesticQuery->where('fair_code', $fairCode);
    }

    $domesticSales = $domesticQuery->get();

    /*
    |--------------------------------------------------------------------------
    | RETAIL SALES
    |--------------------------------------------------------------------------
    */

    $retailQuery = ExhibitorsSuppliersSale::query()
        ->with([
            'sub_category_all:id,name',
            'exhibitor:id,uid,co_name',
        ])
        ->where('sales_type', SalesTypeStatus::RETAIL);

    if (!empty($fairCode)) {
        $retailQuery->where('fair_code', $fairCode);
    }

    $retailSales = $retailQuery->get();

    /*
    |--------------------------------------------------------------------------
    | INQUIRIES
    |--------------------------------------------------------------------------
    */

    $inquiryQuery = ExhibitorsSuppliersSalesInquiry::query()
        ->with([
            'user.latestExhibitor',
        ]);

    if (!empty($fairCode)) {
        $inquiryQuery->where('fair_code', $fairCode);
    }

    $inquiries = $inquiryQuery->get();

    /*
    |--------------------------------------------------------------------------
    | GROUP BY COMPANY
    |--------------------------------------------------------------------------
    */

    $companies = [];

    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */

    foreach ($exportSales as $sale) {

        $company =
            optional($sale->exhibitor)->co_name ?? '-';

        if (!isset($companies[$company])) {

            $companies[$company] = [
                'company' => $company,
                'export' => [],
                'domestic' => [],
                'retail' => [],
                'inquiries' => [],
                'total_activities' => 0,
                'latest_date' => null,
            ];
        }

        $companies[$company]['export'][] = [
            'id' => $sale->id,
            'ff_code' => $sale->ff_code ?? '-',
            'fair_code' => $sale->fair_code ?? '-',
            'date_of_sale' => Carbon::parse(
                $sale->date_of_sale
            )->format('M d, Y'),

            'product_service' =>
                optional($sale->sub_category_all)->name ?? '-',

            'buyer_company' =>
                $sale->co_buyer_name ?? '-',

            'country' =>
                optional($sale->country)->name ?? '-',

            'booked' => number_format(
                (float) $sale->booked,
                2
            ),

            'under_negotiation' => number_format(
                (float) $sale->under_negotiation,
                2
            ),
        ];

        $companies[$company]['total_activities']++;

        $latestDate =
            $companies[$company]['latest_date'];

        $companies[$company]['latest_date'] =
            !$latestDate
                ? $sale->date_of_sale
                : max(
                    $latestDate,
                    $sale->date_of_sale
                );
    }

    /*
    |--------------------------------------------------------------------------
    | DOMESTIC
    |--------------------------------------------------------------------------
    */

    foreach ($domesticSales as $sale) {

        $company =
            optional($sale->exhibitor)->co_name ?? '-';

        if (!isset($companies[$company])) {

            $companies[$company] = [
                'company' => $company,
                'export' => [],
                'domestic' => [],
                'retail' => [],
                'inquiries' => [],
                'total_activities' => 0,
                'latest_date' => null,
            ];
        }

        $companies[$company]['domestic'][] = [
            'id' => $sale->id,
            'ff_code' => $sale->ff_code ?? '-',
            'fair_code' => $sale->fair_code ?? '-',
            'date_of_sale' => Carbon::parse(
                $sale->date_of_sale
            )->format('M d, Y'),

            'product_service' =>
                optional($sale->sub_category_all)->name ?? '-',

            'buyer_company' =>
                $sale->co_buyer_name ?? '-',

            'type_of_buyer' =>
                $sale->type_of_purchaser_buyer ?? '-',

            'booked' => number_format(
                (float) $sale->booked,
                2
            ),

            'under_negotiation' => number_format(
                (float) $sale->under_negotiation,
                2
            ),
        ];

        $companies[$company]['total_activities']++;

        $latestDate =
            $companies[$company]['latest_date'];

        $companies[$company]['latest_date'] =
            !$latestDate
                ? $sale->date_of_sale
                : max(
                    $latestDate,
                    $sale->date_of_sale
                );
    }

    /*
    |--------------------------------------------------------------------------
    | RETAIL
    |--------------------------------------------------------------------------
    */

    foreach ($retailSales as $sale) {

        $company =
            optional($sale->exhibitor)->co_name ?? '-';

        if (!isset($companies[$company])) {

            $companies[$company] = [
                'company' => $company,
                'export' => [],
                'domestic' => [],
                'retail' => [],
                'inquiries' => [],
                'total_activities' => 0,
                'latest_date' => null,
            ];
        }

        $companies[$company]['retail'][] = [
            'id' => $sale->id,
            'ff_code' => $sale->ff_code ?? '-',
            'fair_code' => $sale->fair_code ?? '-',
            'date_of_sale' => Carbon::parse(
                $sale->date_of_sale
            )->format('M d, Y'),

            'product_service' =>
                optional($sale->sub_category_all)->name ?? '-',

            'type_of_buyer' =>
                $sale->type_of_purchaser_buyer ?? '-',

            'booked' => number_format(
                (float) $sale->booked,
                2
            ),
        ];

        $companies[$company]['total_activities']++;

        $latestDate =
            $companies[$company]['latest_date'];

        $companies[$company]['latest_date'] =
            !$latestDate
                ? $sale->date_of_sale
                : max(
                    $latestDate,
                    $sale->date_of_sale
                );
    }

    /*
    |--------------------------------------------------------------------------
    | INQUIRIES
    |--------------------------------------------------------------------------
    */

    foreach ($inquiries as $item) {

        $company =
            optional(
                optional(
                    $item->user
                )->latestExhibitor
            )->co_name ?? '-';

        if (!isset($companies[$company])) {

            $companies[$company] = [
                'company' => $company,
                'export' => [],
                'domestic' => [],
                'retail' => [],
                'inquiries' => [],
                'total_activities' => 0,
                'latest_date' => null,
            ];
        }

        $companies[$company]['inquiries'][] = [
        
            'id' => $item->id,
            'date_of_sale' => Carbon::parse(
                $item->date_of_sale
            )->format('M d, Y'),

            'ff_code' => $item->ff_code ?? '-',
            'fair_code' => $item->fair_code ?? '-',

            'no_of_inquiries' =>
                (int) $item->no_of_inquiries,

            'no_of_buyers_met' =>
                (int) $item->no_of_buyers_met,
        ];

        $companies[$company]['total_activities']++;

        $latestDate =
            $companies[$company]['latest_date'];

        $companies[$company]['latest_date'] =
            !$latestDate
                ? $item->date_of_sale
                : max(
                    $latestDate,
                    $item->date_of_sale
                );
    }

    /*
    |--------------------------------------------------------------------------
    | CONVERT TO COLLECTION
    |--------------------------------------------------------------------------
    */

    $companies = collect($companies);

/*
|--------------------------------------------------------------------------
| FILTERS
|--------------------------------------------------------------------------
*/

$companies = $companies->map(function ($row) use ($filters) {

    /*
    |--------------------------------------------------------------------------
    | FILTER BY DATE INSIDE EACH ACTIVITY ARRAY
    |--------------------------------------------------------------------------
    */

    if (!empty($filters['date_of_sale'])) {

        $filterDate = Carbon::parse(
            $filters['date_of_sale']
        )->format('M d, Y');

        foreach (
            ['export', 'domestic', 'retail', 'inquiries']
            as $activityType
        ) {

            $row[$activityType] = collect(
                $row[$activityType]
            )
            ->filter(function ($activity) use ($filterDate) {

                return isset($activity['date_of_sale']) &&
                    $activity['date_of_sale'] === $filterDate;
            })
            ->values()
            ->toArray();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER BY ACTIVITY TYPE
    |--------------------------------------------------------------------------
    */

    if (!empty($filters['activity_type'])) {

        $type = strtolower(
            $filters['activity_type']
        );

        if ($type === 'inquiry') {
            $type = 'inquiries';
        }

        foreach (
            ['export', 'domestic', 'retail', 'inquiries']
            as $activityType
        ) {

            if ($activityType !== $type) {
                $row[$activityType] = [];
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RECALCULATE TOTAL ACTIVITIES
    |--------------------------------------------------------------------------
    */

    $row['total_activities'] =
        count($row['export']) +
        count($row['domestic']) +
        count($row['retail']) +
        count($row['inquiries']);

    return $row;
});

/*
|--------------------------------------------------------------------------
| REMOVE EMPTY COMPANIES
|--------------------------------------------------------------------------
*/

$companies = $companies->filter(function ($row) use ($filters) {

    /*
    |--------------------------------------------------------------------------
    | COMPANY FILTER
    |--------------------------------------------------------------------------
    */

    if (
        !empty($filters['company']) &&
        stripos(
            $row['company'],
            $filters['company']
        ) === false
    ) {
        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE COMPANIES WITH NO ACTIVITIES
    |--------------------------------------------------------------------------
    */

    return $row['total_activities'] > 0;
});

    /*
    |--------------------------------------------------------------------------
    | SORT
    |--------------------------------------------------------------------------
    */

    // $companies = $companies
    //     ->sortByDesc('latest_date')
    //     ->values();
/*
|--------------------------------------------------------------------------
| SORT
|--------------------------------------------------------------------------
*/

$sort = $request->input('sort', []);

if (is_string($sort)) {
    $sort = json_decode($sort, true);
}

$sort = $sort ?? [];

$sortField = $sort['field'] ?? 'latest_date';

$sortType = $sort['type'] ?? 'desc';

if ($sortField === 'company') {

    $companies = $sortType === 'asc'
        ? $companies->sortBy('company', SORT_NATURAL | SORT_FLAG_CASE)
        : $companies->sortByDesc('company', SORT_NATURAL | SORT_FLAG_CASE);

} else {

    $companies = $sortType === 'asc'
        ? $companies->sortBy('latest_date')
        : $companies->sortByDesc('latest_date');
}

$companies = $companies->values();
    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    $total = $companies->count();

    $data = $companies
        ->slice(
            ($page - 1) * $per_page,
            $per_page
        )
        ->values();

    return response()->json([ 
        'total' => $total,
        'data' => $data,
    ]);
}

public function destroy($type, $id)
{
    switch ($type) {

       

        case 'export':

            $record = ExhibitorsSuppliersSale::query()
                ->where(
                    'sales_type',
                    SalesTypeStatus::EXPORT
                )
                ->findOrFail($id);

            break;

        case 'domestic':

            $record = ExhibitorsSuppliersSale::query()
                ->where(
                    'sales_type',
                    SalesTypeStatus::DOMESTIC
                )
                ->findOrFail($id);

            break;

        case 'retail':

            $record = ExhibitorsSuppliersSale::query()
                ->where(
                    'sales_type',
                    SalesTypeStatus::RETAIL
                )
                ->findOrFail($id);

            break;


        case 'inquiry':

            $record = ExhibitorsSuppliersSalesInquiry::findOrFail($id);

            break;

        default:

            return response()->json([
                'success' => false,
                'message' => 'Invalid activity type.',
            ], 422);
    }

    $record->delete();

    return response()->json([
        'success' => true,
        'message' => ucfirst($type) . ' deleted successfully.',
    ]);
}



public function export(Request $request)
{

    $request->merge([
        'page' => 1,
        'per_page' => 999999,
    ]);

    $data = $this->getActivityData($request);

    $exportRows = [];
    $domesticRows = [];
    $retailRows = [];
    $inquiryRows = [];

    foreach ($data as $companyRow) {

        foreach ($companyRow['export'] ?? [] as $item) {

            $exportRows[] = [
                $companyRow['company'],
                $item['date_of_sale'],
                $item['product_service'],
                $item['buyer_company'],
                $item['country'],
                $item['booked'],
                $item['under_negotiation'],
                $item['fair_code'],
            ];
        }

        foreach ($companyRow['domestic'] ?? [] as $item) {

            $domesticRows[] = [
                $companyRow['company'],
                $item['date_of_sale'],
                $item['product_service'],
                $item['buyer_company'],
                $item['type_of_buyer'],
                $item['booked'],
                $item['under_negotiation'],
                $item['fair_code'],
            ];
        }

        foreach ($companyRow['retail'] ?? [] as $item) {

            $retailRows[] = [
                $companyRow['company'],
                $item['date_of_sale'],
                $item['product_service'],
                $item['type_of_buyer'],
                $item['booked'],
                $item['fair_code'],
            ];
        }

        foreach ($companyRow['inquiries'] ?? [] as $item) {

            $inquiryRows[] = [
                $companyRow['company'],
                $item['date_of_sale'],
                $item['no_of_inquiries'],
                $item['no_of_buyers_met'],
                $item['fair_code'],
            ];
        }
    }

    return Excel::download(
        new GeneralSummaryMultiSheetExport(
            $exportRows,
            $domesticRows,
            $retailRows,
            $inquiryRows
        ),
        'general-summary.xlsx'
    );
}
}