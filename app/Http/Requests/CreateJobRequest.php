<?php

namespace App\Http\Requests;

use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    use HasFailedValidation;

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
            'urls' => ['required', 'array', 'min:1'],
            'selectors' => ['required', 'string', 'min:1'],
        ];
    }
}
