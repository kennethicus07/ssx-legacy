<?php

namespace App\Modules\InternalEvent\Promo\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyPromoRequest extends FormRequest
{
    public function rules()
    {
        return [
            'promo_code' => 'required|string',
            'attendee_type_id' => 'required|integer',
            'fair_code' => 'required|string'
        ];
    }
}