<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'category_id' => 'required|exists:job_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Job title is required',
            'title.max' => 'Job title must be less than 255 characters',
            'title.string' => 'Job title must be a string',
            'description.required' => 'Job description is required',
            'description.max' => 'Job description must be less than 255 characters',
            'description.string' => 'Job description must be a string',
            'location.required' => 'Job location is required',
            'location.max' => 'Job location must be less than 255 characters',
            'location.string' => 'Job location must be a string',
            'salary.required' => 'Job salary is required',
            'salary.numeric' => 'Job salary must be a number',
            'salary.min' => 'Job salary must be greater than 0',
            'type.required' => 'Job type is required',
            'type.string' => 'Job type must be a string',
            'type.max' => 'Job type must be less than 255 characters',
            'company_id.required' => 'Job company is required',
            'company_id.exists' => 'Selected company is invalid',
            'category_id.required' => 'Job category is required',
            'category_id.exists' => 'Selected category is invalid',
        ];
    }
}
