<?php

namespace App\Modules\InternalEvent\Promo\Actions;

use App\Modules\InternalEvent\Promo\Services\PromoService;

class GeneratePromoCodeAction
{
    protected $service;

    public function __construct(PromoService $service)
    {
        $this->service = $service;
    }

    public function execute(array $data): string
    {
        return $this->service->generateDiscountedCode(
            $data['promo_id'],
            $data['email'],
            $data['fair_code']
        );
    }
}