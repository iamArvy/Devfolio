<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'location' => ['sometimes', 'string'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['string'],
            'date_acquired' => ['nullable', 'date'],

            'media' => ['nullable', 'string'],
            'media_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,docx'],

            'link' => ['nullable', 'string', 'url'],
        ];
    }

}
