<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothSystemAssignment;
use App\Models\BoothSystemAssigmnetGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exhibitor;
use Illuminate\Support\Facades\DB;
class BoothSystemAssignmentGroupController extends Controller
{

    public function index(BoothSystemAssignment $assignment)
    {
        return view(
            'admin.booth_system_assignment.groups.index',
            compact('assignment')
        );
    }


public function list(
    Request $request,
    BoothSystemAssignment $assignment
) {
    $perPage = $request->input('per_page', 10);
    $page = $request->input('page', 1);

    $filters = $request->has('filter')
        ? json_decode($request->input('filter'), true)
        : [];

    $groups = $assignment->groups()
        ->with([
            'assignedBy',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

    if (!empty($filters['name'])) {
        $groups->where(
            'name',
            'like',
            '%' . $filters['name'] . '%'
        );
    }

    if (!empty($filters['classification'])) {
        $groups->where(
            'classification',
            'like',
            '%' . $filters['classification'] . '%'
        );
    }

    if (!empty($filters['booth_name'])) {
        $groups->where(
            'booth_name',
            'like',
            '%' . $filters['booth_name'] . '%'
        );
    }

    if (!empty($filters['booth_type'])) {
        $groups->where(
            'booth_type',
            'like',
            '%' . $filters['booth_type'] . '%'
        );
    }

    if (!empty($filters['hall_name'])) {
        $groups->where(
            'hall_name',
            'like',
            '%' . $filters['hall_name'] . '%'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */

    if ($request->has('sort')) {
        $sort = json_decode(
            $request->input('sort'),
            true
        );

        $allowedSorts = [
            'name',
            'classification',
            'booth_name',
            'booth_type',
            'hall_name',
            'booth',
            'created_at',
        ];

        if (
            isset($sort['field']) &&
            in_array($sort['field'], $allowedSorts)
        ) {
            $groups->orderBy(
                $sort['field'],
                $sort['type'] ?? 'asc'
            );
        }
    } else {
        $groups->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    $total = $groups->count();

    $records = $groups
        ->offset(($page - 1) * $perPage)
        ->limit($perPage)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    $permissions = [
        'can_view' => Auth::user()->can(
            'view booth_system_assignments'
        ),

        'can_add' => Auth::user()->can(
            'add booth_system_assignments'
        ),

        'can_edit' => Auth::user()->can(
            'edit booth_system_assignments'
        ),

        'can_delete' => Auth::user()->can(
            'delete booth_system_assignments'
        ),
    ];

    return response()->json([
        'total' => $total,

        'data' => $records,

        'permissions' => $permissions,

        'assignment' => $assignment,
    ], 200);
}



public function store(
    Request $request,
    BoothSystemAssignment $assignment
) {
    $validated = $request->validate([
        'exhibitor_ids' => [
            'required',
            'array',
            'min:1',
        ],

        'exhibitor_ids.*' => [
            'required',
            'integer',
        ],

        'booth' => [
            'nullable',
            'string',
            'max:255',
        ],

        /*
        |--------------------------------------------------------------------------
        | Supplier Information
        |--------------------------------------------------------------------------
        |
        | These are sent from the Vue multiselect for each supplier.
        |
        */

        'suppliers' => [
            'required',
            'array',
            'min:1',
        ],

        'suppliers.*.uid' => [
            'required',
            'integer',
        ],

        'suppliers.*.classification' => [
            'required',
            'string',
            'max:255',
        ],

        'suppliers.*.booth_name' => [
            'required',
            'string',
            'max:255',
        ],

        'suppliers.*.booth_name_length' => [
            'nullable',
            'integer',
        ],

        'suppliers.*.booth_type' => [
            'nullable',
            'string',
            'max:255',
        ],

        'suppliers.*.hall_name' => [
            'nullable',
            'string',
            'max:255',
        ],
    ]);


    $groups = DB::transaction(function () use (
        $validated,
        $assignment
    ) {
        $createdGroups = collect();

        foreach ($validated['suppliers'] as $supplierData) {

  

            $exhibitor = Exhibitor::query()
                ->where('uid', $supplierData['uid'])
                ->where('fair_code', $assignment->fair_code)
                ->first();

            if (!$exhibitor) {
                abort(
                    422,
                    'One of the selected supplier / exhibitors does not belong to this fair.'
                );
            }



            if (
                !in_array(
                    $supplierData['uid'],
                    $validated['exhibitor_ids']
                )
            ) {
                abort(
                    422,
                    'Invalid supplier selection.'
                );
            }

    

            $group = $assignment->groups()->create([
                'fair_code' => $assignment->fair_code,
                'name' => $supplierData['name'],
                'uid' => $supplierData['uid'],
                'classification' =>
                    $supplierData['classification'],

                'booth_name' =>
                    $supplierData['booth_name'],

                'booth_name_length' =>
                    $supplierData['booth_name_length'] ?? null,

                'booth_type' =>
                    $supplierData['booth_type'] ?? null,

                'hall_name' =>
                    $supplierData['hall_name'] ?? null,

                'booth' =>
                    $validated['booth'] ?? null,

                'assigned_by' => Auth::id(),
            ]);

            $group->load([
                'assignedBy',
            ]);

            $createdGroups->push($group);
        }

        return $createdGroups;
    });

    return response()->json([
        'success' => true,

        'message' =>
            $groups->count() > 1
                ? $groups->count() . ' assignment groups successfully created.'
                : 'Assignment group successfully created.',

        'data' => $groups,
    ], 201);
}


public function update(
    Request $request,
    BoothSystemAssignment $assignment,
    $group
) {
    $group = $assignment->groups()->findOrFail($group);

    $validated = $request->validate([
        'exhibitor_id' => [
            'required',
            'integer',
        ],

        'classification' => [
            'required',
            'string',
            'max:255',
        ],

        'booth_name' => [
            'required',
            'string',
            'max:255',
        ],

        'booth_name_length' => [
            'nullable',
            'integer',
        ],

        'booth_type' => [
            'nullable',
            'string',
            'max:255',
        ],

        'hall_name' => [
            'nullable',
            'string',
            'max:255',
        ],

        'booth' => [
            'nullable',
            'string',
            'max:255',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Verify Exhibitor belongs to this fair
    |--------------------------------------------------------------------------
    */

    $exhibitor = Exhibitor::query()
        ->where('uid', $validated['exhibitor_id'])
        ->where('fair_code', $assignment->fair_code)
        ->first();

    if (!$exhibitor) {
        return response()->json([
            'success' => false,
            'message' => 'The selected supplier / exhibitor does not belong to this fair.',
        ], 422);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Group
    |--------------------------------------------------------------------------
    */

    $group->update([
        'fair_code' => $assignment->fair_code,

        'exhibitor_id' => $validated['exhibitor_id'],

        'classification' => $validated['classification'],

        'booth_name' => $validated['booth_name'],

        'booth_name_length' =>
            $validated['booth_name_length'] ?? null,

        'booth_type' =>
            $validated['booth_type'] ?? null,

        'hall_name' =>
            $validated['hall_name'] ?? null,

        'booth' =>
            $validated['booth'] ?? null,
    ]);


    $group->load([
        'assignedBy',
    ]);

    return response()->json([
        'success' => true,

        'message' => 'Assignment group successfully updated.',

        'data' => $group,
    ]);
}


    public function destroy(
        BoothSystemAssignment $assignment,
        BoothSystemAssigmnetGroup $group
    ) {


        if (
            $group->booth_system_assignment_id !==
            $assignment->id
        ) {
            abort(404);
        }

        $group->delete();

        return response()->json([
            'success' => true,

            'message' => 'Assignment group successfully deleted.',
        ], 200);
    }

public function suppliers($assignment)
{
    $assignment = BoothSystemAssignment::findOrFail($assignment);

    $suppliers = Exhibitor::query()
        ->where('exhibitors.fair_code', $assignment->fair_code)
        ->with([
            'participationSelections' => function ($query) use ($assignment) {
                $query
                    ->where('fair_code', $assignment->fair_code)
                    ->with([
                        'package:id,sub_title',
                    ]);
            },
        ])
        ->select([
            'uid',
            'fair_code',
            'fascia_name',
            'co_name',
            'directory_name',
        ])
        ->orderBy('fascia_name')
        ->get();

    $suppliers = $suppliers->map(function ($supplier) {

        $selections = $supplier->participationSelections;



        $boothTypes = $selections
            ->map(function ($selection) {

                $package = trim((string) $selection->booth_package);
                $size = trim((string) $selection->booth_size_name);

                if ($package && $size) {
                    return $package . ' (' . $size . ')';
                }

                return $package ?: $size;
            })
            ->filter()
            ->unique()
            ->implode(', ');


        $halls = $selections
            ->map(function ($selection) {
                return optional($selection->package)->sub_title;
            })
            ->filter()
            ->unique()
            ->implode(', ');

        return [
            'uid' => $supplier->uid,

            'fair_code' => $supplier->fair_code,

            /*
             * Classification
             */
            'classification' => 'EXB',

            /*
             * fascia_name = Booth Name
             */
            'booth_name' => $supplier->fascia_name,

            /*
             * Existing company information
             */
            'fascia_name' => $supplier->fascia_name,
            'co_name' => $supplier->co_name,
            'directory_name' => $supplier->directory_name,

            /*
             * Participation information
             */
            'booth_type' => $boothTypes,
            'hall_name' => $halls,
        ];
    });

    return response()->json([
        'suppliers' => $suppliers,
    ]);
}
}