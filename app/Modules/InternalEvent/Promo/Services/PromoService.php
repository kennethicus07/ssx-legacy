<?php

namespace App\Modules\InternalEvent\Promo\Services;

use App\Modules\InternalEvent\Promo\Repositories\PromoRepository as RepositoriesPromoRepository;

class PromoService
{
    protected $repo;

    public function __construct(RepositoriesPromoRepository $repo)
    {
        $this->repo = $repo;
    }

 public function generateDiscountedCode(int $promoId, string $email, string $fairCode): string
{
    $promo = $this->repo->findPromo($promoId);

    if ($promo->promo_type !== $promo::TYPE_DISCOUNTED) {
        throw new \Exception('Cannot generate code for this promo type.');
    }

    $emailPrefix = strtoupper(substr($email, 0, 3));
    $discLabel   = 'DISC';
    $salt        = config('app.key');
    $timestamp   = now()->format('YmdHis');

    $attempt = 0;
    $maxAttempts = 10;

    do {
        $hash1 = strtoupper(substr(
            sha1($email . $fairCode . $timestamp . $salt . $attempt),
            0,
            5
        ));

        $hash2 = strtoupper(substr(
            sha1($promo->id . $timestamp . $salt . $attempt),
            0,
            5
        ));

        $code = "{$emailPrefix}-{$discLabel}-{$hash1}-{$hash2}";

        $exists = $this->repo->promoCodeExists($fairCode, $code);

        $attempt++;

        if ($attempt > $maxAttempts) {
            throw new \Exception('Unable to generate a unique promo code.');
        }

    } while ($exists);

    return $code;
}


}