<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry_id' => 'required|exists:industries,id',
            'website' => 'nullable|string|url',
            'owner_id' => 'nullable|string|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'name.unique' => 'Company name must be unique',
            'name.max' => 'Company name must be less than 255 characters',
            'name.string' => 'Company name must be a string',
            'address.required' => 'Company address is required',
            'address.max' => 'Company address must be less than 255 characters',
            'address.string' => 'Company address must be a string',
            'industry_id.required' => 'Company industry is required',
            'industry_id.exists' => 'Selected industry is invalid',
            'website.url' => 'Company website must be a valid URL',
            'owner_id.exists' => 'Selected owner is invalid',
        ];
    }
}
