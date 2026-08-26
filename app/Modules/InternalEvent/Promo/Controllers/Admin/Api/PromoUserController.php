<?php

namespace App\Modules\InternalEvent\Promo\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\InternalEvent\InternalEventPromo;
use App\Models\InternalEvent\InternalEventPromoAllowedType;
use Illuminate\Http\Request;
use App\Models\InternalEvent\InternalEventPromoUser;
use App\Modules\InternalEvent\Promo\Actions\GeneratePromoCodeAction;
use App\Modules\InternalEvent\Promo\Requests\GeneratePromoCodeRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PromoUserController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page    = $request->input('page', 1);

        $query = InternalEventPromoUser::with(['attendeeType','promo']);

        //! Filters
        $filters = $request->input('filter', []);

        if (!empty($filters['co_email'])) {
            $query->where('email', 'like', '%'.$filters['co_email'].'%');
        }

        if (!empty($filters['attendee_type'])) {
            $query->whereHas('attendeeType', function ($q) use ($filters) {
                $q->where('name', $filters['attendee_type']);
            });
        }

        if (!empty($filters['fair_code'])) {
            $query->where('fair_code', $filters['fair_code']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status'] === 'active' ? 1 : 0);
        }

            
        if (!empty($filters['promo_code'])) {
            $query->where('promo_code', 'like', '%'.$filters['promo_code'].'%');
        }

      
        if (isset($filters['redeemed']) && $filters['redeemed'] !== '') {
            $query->where('redeemed', $filters['redeemed'] === 'yes' ? 1 : 0);
        }

       
        if (!empty($filters['redeemed_by_email'])) {
            $query->where('redeemed_by_email', 'like', '%'.$filters['redeemed_by_email'].'%');
        }

        //! Sorting
        $sortField = $request->input('sort.field', 'created_at');
        $sortType  = strtolower($request->input('sort.type', 'desc'));

        // ensure direction is valid
        if (!in_array($sortType, ['asc','desc'])) {
            $sortType = 'desc';
        }

        // allowed fields from frontend
        $allowedSorts = [
            'co_email',
            'promo_code',
            'status',
            'fair_code',
            'created_at'
        ];

        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        switch ($sortField) {

            case 'co_email':
                $query->orderBy('email', $sortType);
                break;

            case 'promo_code':
                $query->orderBy('promo_code', $sortType);
                break;

            case 'status':
                $query->orderBy('status', $sortType);
                break;

            case 'fair_code':
                $query->orderBy('fair_code', $sortType);
                break;

            default:
                $query->orderBy('created_at', $sortType);
        }

        //! Pagination
        $records = $query->paginate($perPage, ['*'], 'page', $page);

        

        $data = collect($records->items())->map(function ($promoUser) {

   Log::info('Promo User Debug', [
        'id' => $promoUser->id,
        'attendee_type_id' => $promoUser->attendee_type_id,
        'attendeeType' => $promoUser->attendeeType,
    ]);


    
            return [
                'id' => $promoUser->id,
                'co_email' => $promoUser->email,
                'promo_id' => $promoUser->promo_id,
                'promo_code' => $promoUser->promo_code ?? '—',
                'fair_code' => $promoUser->fair_code,
                'attendee_type_id' => $promoUser->attendee_type_id,
                'attendee_type' => $promoUser->attendeeType->name ?? '—',
                'starts_at' => $promoUser->starts_at->format('Y-m-d H:i:s'),
                'expires_at' => $promoUser->expires_at->format('Y-m-d H:i:s'),
                'status' => $promoUser->status ? 'Active' : 'Inactive',
                'redeemed' => $promoUser->redeemed,
                'redeemed_by_email' => $promoUser->redeemed_by_email ?? '—',
                'redeemed_at' => $promoUser->redeemed_at
                    ? $promoUser->redeemed_at->format('Y-m-d H:i:s')
                    : null,
                'created_at' => $promoUser->created_at
                    ? $promoUser->created_at->format('Y-m-d H:i:s')
                    : null,
            ];
        });

        return response()->json([
            'total' => $records->total(),
            'data'  => $data,
        ]);
    }


 public function generateCode(GeneratePromoCodeRequest $request, GeneratePromoCodeAction $action)
    {
        try {
            $code = $action->execute($request->validated());

            return response()->json(['code' => $code]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'email'            => 'required|email',
        'fair_code'        => 'required',
        'promo_id'         => 'required|exists:internal_event_promos,id',
        'promo_code'       => 'required',
        'starts_at'        => 'required',
        'expires_at'       => 'required',
        'attendee_type_id' => 'required|exists:attendee_types,id',
    ]);

    InternalEventPromoUser::create([
        'email'            => $data['email'],
        'fair_code'        => $data['fair_code'],
        'promo_id'         => $data['promo_id'],
        'promo_code'       => $data['promo_code'],
        'attendee_type_id' => $data['attendee_type_id'],
        'starts_at'        => $data['starts_at'],
        'expires_at'       => $data['expires_at'],
        'status'           => 1,
        'redeemed'         => 0,
    ]);

    return response()->json([
        'success' => true,
    ]);
}

public function update(
    Request $request,
    InternalEventPromoUser $promoUser
) {
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'fair_code' => ['required', 'string'],
        'promo_id' => ['required', 'exists:internal_event_promos,id'],
        'attendee_type_id' => ['required', 'exists:attendee_types,id'],
        'promo_code' => ['nullable', 'string'],
        'starts_at' => 'required',
        'expires_at' => 'required'
    ]);

    $promo = InternalEventPromo::findOrFail(
        $validated['promo_id']
    );

    // Free promos always use their fixed code
    if ($promo->promo_type == InternalEventPromo::TYPE_FREE) {
        $validated['promo_code'] = $promo->promo_code;
    }

    // Update assignment
    $promoUser->update([
        'email' => $validated['email'],
        'fair_code' => $validated['fair_code'],
        'promo_id' => $validated['promo_id'],
        'starts_at' => $validated['starts_at'],
        'expires_at' => $validated['expires_at'],
        'promo_code' => $validated['promo_code'],
        'attendee_type_id' => $validated['attendee_type_id'],
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Promo assignment updated successfully.',
    ]);
}


    public function destroy($id)
    {
        $promoUser = InternalEventPromoUser::findOrFail($id);
        $promoUser->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}