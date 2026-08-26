<?php
namespace App\Modules\InternalEvent\Promo\Repositories;

use App\Models\InternalEvent\InternalEventPromo;
use App\Models\InternalEvent\InternalEventPromoUser;

class PromoRepository
{

public function findPromo(int $id): InternalEventPromo
    {
        return InternalEventPromo::findOrFail($id);
    }

    public function promoCodeExists(string $fairCode, string $promoCode): bool
    {
        return InternalEventPromoUser::where('fair_code', $fairCode)
            ->where('promo_code', $promoCode)
            ->exists();
    }

    public function savePromoUser(array $data)
    {
        return InternalEventPromoUser::create($data);
    }
}