<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAcademicRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $rules = [
            'record_type' => ['required', Rule::in(['publication', 'course', 'designation', 'achievement'])],
            'title' => ['required', 'string', 'max:255'],
            'subtitle_or_institution' => ['nullable', 'string', 'max:255'],
            'date_or_year' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:5000'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['slug'] = ['nullable', 'string', 'max:255', Rule::unique('academic_records', 'slug')->ignore($this->route('academic_record'))];
        } else {
            $rules['slug'] = ['nullable', 'string', 'max:255', 'unique:academic_records,slug'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => filter_var($this->input('is_active', false), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
