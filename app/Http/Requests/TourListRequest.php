<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'priceFrom' => ['nullable', 'numeric', 'min:0'],
            'priceTo' => ['nullable', 'numeric', 'min:0'],
            'dateFrom' => ['nullable', 'date'],
            'dateTo' => ['nullable', 'date'],
            'sortBy' => ['nullable', 'string', Rule::in(['price'])],
            'sortOrder' => ['nullable', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    public function messages(): array
    {
        return [
            'sortBy' => 'The sort by field must be one of the following types: price.',
            'sortOrder' => 'The sort order field must be one of the following types: asc, desc.'
        ];
    }
}
