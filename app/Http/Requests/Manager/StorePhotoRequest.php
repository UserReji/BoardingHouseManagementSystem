<?php

namespace App\Http\Requests\Manager;

use Illuminate\Foundation\Http\FormRequest;

class StorePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isManager() ?? false;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['nullable', 'exists:rooms,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'photo' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:6144'],
            'taken_at' => ['nullable', 'date'],
            'is_featured' => ['nullable', 'boolean'],
            'visibility' => ['required', 'in:public,tenants,managers'],
        ];
    }
}
