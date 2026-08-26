<?php 
namespace App\Modules\InternalEvent\Promo\Services;

use Exception;

class PromoValidator
{
    public function validateExpiry($promo)
    {
        if ($promo->expires_at && now()->gt($promo->expires_at)) {
            throw new Exception('Promo expired');
        }
    }

    public function validateUsageLimit($promo)
    {
        if (!$promo->usage_limit) {
            return;
        }

        if ($promo->users()->count() >= $promo->usage_limit) {
            throw new Exception('Promo usage limit reached');
        }
    }

    public function validateAttendeeType($promo,$attendeeTypeId)
    {
        if (!$promo->allowedTypes()->exists()) {
            return;
        }

        $allowed = $promo->allowedTypes()
            ->where('attendee_type_id',$attendeeTypeId)
            ->exists();

        if (!$allowed) {
            throw new Exception('Promo not allowed for this attendee type');
        }
    }
}