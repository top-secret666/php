<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'performance_id' => 'required|exists:performances,id',
            'seat_id' => 'required|exists:seats,id',
            // allow either a direct price or a price_tier reference
            'price_tier_id' => 'nullable|exists:price_tiers,id',
            'price' => 'nullable|numeric',
            'order_id' => 'nullable|exists:orders,id',
            'status' => 'nullable|in:reserved,sold,cancelled',
            'qr_code' => 'nullable|string',
            'checked_in_at' => 'nullable|date',
        ];
    }
}
