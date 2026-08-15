<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMusicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'record_type' => ['required', Rule::in(['band_info', 'discography', 'instrument', 'course'])],
            'title' => ['required', 'string', 'max:255'],
            'media_url' => ['nullable', 'string', 'max:500', 'url'],
            'body' => ['nullable', 'string', 'max:10000'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['slug'] = ['nullable', 'string', 'max:255', Rule::unique('musical_records', 'slug')->ignore($this->route('musical_record'))];
        } else {
            $rules['slug'] = ['nullable', 'string', 'max:255', 'unique:musical_records,slug'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}
