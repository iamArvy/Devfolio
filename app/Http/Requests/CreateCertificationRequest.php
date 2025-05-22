<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCertificationRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'location' => ['required', 'string'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['string'],
            'date_acquired' => ['nullable', 'date'],

            // accept either a string (link) or a file
            'media' => ['nullable', 'string'], // optional: validate as URL here or in controller
            'media_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,docx'], // optional file field

            'link' => ['nullable', 'string', 'url'],
        ];
    }

}
