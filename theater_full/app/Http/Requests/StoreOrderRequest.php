<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // For regular users user_id will be forced to the current user in controller.
            // Admin may create orders for any user.
            'user_id' => 'nullable|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'nullable|string',
        ];
    }
}
