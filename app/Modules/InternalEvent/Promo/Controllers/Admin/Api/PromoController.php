<?php

namespace App\Modules\InternalEvent\Promo\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\InternalEvent\InternalEventPromo;
use App\Models\InternalEvent\InternalEventPromoAllowedType;
use App\Modules\InternalEvent\Promo\Requests\ApplyPromoRequest;
use App\Modules\InternalEvent\Promo\Actions\ApplyPromoAction;
use Illuminate\Http\Request;

class PromoController extends Controller
{

    public function index(Request $request)
    {
        $fairCode = $request->input('fair_code'); 

        $query = InternalEventPromo::query()->where('access_type', '!=', 1);

        if ($fairCode) {
            $query->where('fair_code', $fairCode);
        }

        $promos = $query->get()->map(function ($promo) {
            return [
                'id' => $promo->id,
                'promo_code' => $promo->promo_code,
                'promo_type' => $promo->promo_type,
                'starts_at' => $promo->starts_at,
                'expires_at' => $promo->expires_at,
                'promo_type_label' => $promo->promo_type_label,
                'discount_type' => $promo->discount_type,
                'discount_value' => $promo->discount_value,
                'TYPE_FREE' => InternalEventPromo::TYPE_FREE,
                'TYPE_DISCOUNTED' => InternalEventPromo::TYPE_DISCOUNTED,
                'DISCOUNT_PERCENT' => InternalEventPromo::DISCOUNT_PERCENT,
                'DISCOUNT_FIXED' => InternalEventPromo::DISCOUNT_FIXED,
            ];
        });

        return response()->json($promos);
    } 

    
public function getAllowedAttendeeTypes(Request $request)
{
    $request->validate([
        'promo_id' => 'required|exists:internal_event_promos,id'
    ]);

    $types = InternalEventPromoAllowedType::with('attendeeType')
        ->where('promo_id', $request->promo_id)
        ->get()
        ->map(function ($item) {
            return [
                'id'   => $item->attendeeType->id,
                'name' => $item->attendeeType->name,
            ];
        });

    return response()->json($types);
}

    public function apply(
        ApplyPromoRequest $request,
        ApplyPromoAction $action
    ){

        $result = $action->execute(
            $request->promo_code,
            $request->attendee_type_id,
            $request->fair_code
        );

        return response()->json($result);

    }
}