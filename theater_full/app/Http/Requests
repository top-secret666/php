<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'performance_id' => 'required|exists:performances,id',
            'seat_id' => 'required|exists:seats,id',
            'price_tier_id' => 'required|exists:price_tiers,id',
            'order_id' => 'nullable|exists:orders,id',
            'status' => 'nullable|in:reserved,sold,cancelled',
        ];
    }
}
