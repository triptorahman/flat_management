<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlatRequest extends FormRequest
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
        $buildingId = auth('house_owner')->user()->building?->id;
        $flatId = $this->route('flat')?->id; // For update requests
        
        return [
            'flat_number' => [
                'required',
                'string',
                'max:20',
                "unique:flats,flat_number,{$flatId},id,building_id,{$buildingId}"
            ],
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:20|regex:/^[\d\s\+\-\(\)]+$/',
            'owner_email' => 'nullable|email|max:255',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'flat_number' => 'flat number',
            'owner_name' => 'flat owner name',
            'owner_contact' => 'flat owner contact',
            'owner_email' => 'flat owner email',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'flat_number.required' => 'The flat number is required.',
            'flat_number.max' => 'The flat number cannot exceed 20 characters.',
            'flat_number.unique' => 'This flat number already exists in the building.',
            'owner_contact.regex' => 'The contact number format is invalid.',
            'owner_email.email' => 'Please provide a valid email address.',
        ];
    }

    /**
     * Get validated flat data
     */
    public function getFlatData(): array
    {
        return $this->only([
            'flat_number',
            'owner_name',
            'owner_contact',
            'owner_email',
        ]);
    }
}