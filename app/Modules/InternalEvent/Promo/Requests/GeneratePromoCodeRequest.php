<?php 
namespace App\Modules\InternalEvent\Promo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePromoCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'promo_id'  => 'required|exists:internal_event_promos,id',
            'email'     => 'required|email',
            'fair_code' => 'required|string',
        ];
    }
}