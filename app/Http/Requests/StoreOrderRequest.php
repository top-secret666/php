<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|in:pending,paid,cancelled',
            'total_cents' => 'required|integer|min:0',
            'currency' => 'required|string|size:3',
            'placed_at' => 'nullable|date',
        ];
    }
}
