<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class StoreTenantBillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isManager() ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'billing_period_id' => ['required', 'exists:billing_periods,id'],
            'rent_amount' => ['required', 'numeric', 'min:0'],
            'electricity_amount' => ['nullable', 'numeric', 'min:0'],
            'water_amount' => ['nullable', 'numeric', 'min:0'],
            'other_charges' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'string'],
            'due_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
