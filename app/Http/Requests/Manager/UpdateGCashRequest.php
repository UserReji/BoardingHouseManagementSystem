<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGCashRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isManager() ?? false;
    }

    public function rules(): array
    {
        return [
            'account_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'qr' => ['nullable', 'image', 'max:4096'],
            'instructions' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
