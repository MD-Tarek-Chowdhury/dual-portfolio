<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UploadHeroImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'setting_key' => ['required', 'string', 'in:hero_parent_image,hero_academic_image,hero_music_image'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.max' => 'The image must not exceed 2MB.',
            'image.mimes' => 'Only JPG and PNG images are allowed.',
        ];
    }
}
