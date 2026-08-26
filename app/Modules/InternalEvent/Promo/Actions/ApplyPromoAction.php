<?php

namespace App\Modules\InternalEvent\Promo\Actions;

use App\Modules\InternalEvent\Promo\Repositories\PromoRepository;
use App\Modules\InternalEvent\Promo\Services\PromoValidator;
use Exception;

class ApplyPromoAction
{
    protected $promoRepo;
    protected $validator;

    public function __construct(
        PromoRepository $promoRepo,
        PromoValidator $validator
    ){
        $this->promoRepo = $promoRepo;
        $this->validator = $validator;
    }

    public function execute($promoCode,$attendeeTypeId,$fairCode)
    {
        $promo = $this->promoRepo
            ->findActivePromo($promoCode,$fairCode);

        if (!$promo) {
            throw new Exception('Promo not found');
        }

        $this->validator->validateExpiry($promo);
        $this->validator->validateUsageLimit($promo);
        $this->validator->validateAttendeeType($promo,$attendeeTypeId);

        return [
            'promo_id' => $promo->id,
            'discount_type' => $promo->discount_type,
            'discount_value' => $promo->discount_value
        ];
    }
}