<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoothSystemAssignment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoothSystemAssignmentController extends Controller
{

    public function index()
    {
        return view('admin.booth_system_assignment.index');
    }

    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $filters = $request->has('filter')
            ? json_decode($request->input('filter'), true)
            : [];

        $fairCode = $filters['fair_code'] ?? null;

        if (!$fairCode) {
            $latestEvent = Event::latest()->first();

            $fairCode = $latestEvent
                ? $latestEvent->fair_code
                : null;
        }

        $assignments = BoothSystemAssignment::with([
            'creator',
            'updater',
            'groups',
        ]);

  

        if (!empty($filters['name'])) {
            $assignments->where(
                'name',
                'like',
                '%' . $filters['name'] . '%'
            );
        }

        if (!empty($fairCode)) {
            $assignments->where(
                'fair_code',
                $fairCode
            );
        }



        if ($request->has('sort')) {
            $sort = json_decode(
                $request->input('sort'),
                true
            );

            $allowedSorts = [
                'name',
                'fair_code',
                'created_at',
            ];

            if (
                isset($sort['field']) &&
                in_array(
                    $sort['field'],
                    $allowedSorts
                )
            ) {
                $assignments->orderBy(
                    $sort['field'],
                    $sort['type'] ?? 'desc'
                );
            }
        } else {
            $assignments->latest();
        }

  

        $total = $assignments->count();

 

        $records = $assignments
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get()
            ->map(function ($assignment) {

                $assignment->group_count =
                    $assignment->groups->count();

                return $assignment;
            });


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
            'default_fair_code' => $fairCode,
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'fair_code' => [
                'required',
                'string',
                'max:255',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $assignment = BoothSystemAssignment::create([
            'fair_code' => $validated['fair_code'],
            'name' => $validated['name'],
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        $assignment->load([
            'creator',
            'updater',
            'groups',
        ]);

        $assignment->group_count =
            $assignment->groups->count();

        return response()->json([
            'success' => true,
            'message' => 'Assignment successfully created.',
            'data' => $assignment,
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $assignment = BoothSystemAssignment::findOrFail($id);

        $validated = $request->validate([
            'fair_code' => [
                'required',
                'string',
                'max:255',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $assignment->update([
            'fair_code' => $validated['fair_code'],
            'name' => $validated['name'],
            'updated_by' => Auth::id(),
        ]);

        $assignment->load([
            'creator',
            'updater',
            'groups',
        ]);

        $assignment->group_count =
            $assignment->groups->count();

        return response()->json([
            'success' => true,
            'message' => 'Assignment successfully updated.',
            'data' => $assignment,
        ], 200);
    }

   
    public function destroy($id)
    {
        $assignment = BoothSystemAssignment::findOrFail($id);

        $assignment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment successfully deleted.',
        ], 200);
    }
}