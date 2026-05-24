<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceiptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isTenant() ?? false;
    }

    public function rules(): array
    {
        return [
            'tenant_bill_id' => ['nullable', 'exists:tenant_bills,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'reference_number' => ['nullable', 'string', 'max:255'],
            'paid_at' => ['required', 'date'],
            'receipt' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
