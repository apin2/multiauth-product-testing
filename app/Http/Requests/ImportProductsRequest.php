<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Admins can import products
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:151200',
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'A file is required for import.',
            'file.mimes' => 'The file must be a CSV or Excel file (csv, xlsx, or xls).',
            'file.max' => 'The file size must not exceed 50MB.',
        ];
    }
}
