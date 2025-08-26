<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class JobApplicationUpdateRequest extends FormRequest
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
            'status' => 'required|string|in:pending,shortlisted,rejected,accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Job status is required',
            'status.string' => 'Job status must be a string',
            'status.in' => 'Job status must be a valid status',
        ];
    }
}
