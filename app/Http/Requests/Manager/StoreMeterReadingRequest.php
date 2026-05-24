<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeterReadingRequest extends FormRequest
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
            'type' => ['required', 'in:electricity,water'],
            'previous_reading' => ['required', 'numeric', 'min:0'],
            'current_reading' => ['required', 'numeric', 'gte:previous_reading'],
            'rate' => ['required', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'read_at' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
