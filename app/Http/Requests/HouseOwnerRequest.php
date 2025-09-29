<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class HouseOwnerRequest extends FormRequest
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
        $rules = [
            // House Owner validation rules
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', Password::min(8)],
            'contact' => ['nullable', 'string', 'max:255'],
            
            // Building validation rules
            'building_name' => ['required', 'string', 'max:255'],
            'building_address' => ['required', 'string', 'max:1000'],
        ];

        
        if ($this->isMethod('post')) {
            // For create (store) - email must be unique
            $rules['email'][] = 'unique:house_owners,email';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // For update - email must be unique except current record
            try {
                $houseOwner = $this->route('house_owner');
                $houseOwnerId = is_object($houseOwner) ? $houseOwner->id : $houseOwner;
                $rules['email'][] = 'unique:house_owners,email,' . $houseOwnerId;
            } catch (\Exception $e) {
                // If route parameter access fails, just require unique email
                $rules['email'][] = 'unique:house_owners,email';
            }
            // Make password optional for updates
            $rules['password'] = ['nullable', 'string', Password::min(8)];
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The owner name field is required.',
            'name.string' => 'The owner name must be a string.',
            'name.max' => 'The owner name may not be greater than 255 characters.',
            
            'email.required' => 'The email address field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.max' => 'The email may not be greater than 255 characters.',
            
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            
            'contact.max' => 'The contact field may not be greater than 255 characters.',
            
            'building_name.required' => 'The building name field is required.',
            'building_name.string' => 'The building name must be a string.',
            'building_name.max' => 'The building name may not be greater than 255 characters.',
            
            'building_address.required' => 'The building address field is required.',
            'building_address.string' => 'The building address must be a string.',
            'building_address.max' => 'The building address may not be greater than 1000 characters.',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'owner name',
            'email' => 'email address',
            'password' => 'password',
            'contact' => 'contact',
            'building_name' => 'building name',
            'building_address' => 'building address',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from string fields
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => strtolower(trim($this->email ?? '')),
            'contact' => trim($this->contact ?? ''),
            'building_name' => trim($this->building_name ?? ''),
            'building_address' => trim($this->building_address ?? ''),
        ]);
    }

    /**
     * Get validated data for house owner.
     *
     * @return array
     */
    public function getHouseOwnerData(): array
    {
        $data = $this->only(['name', 'email', 'contact']);
        
        if ($this->filled('password')) {
            $data['password'] = bcrypt($this->password);
        }
        
        return $data;
    }

    /**
     * Get validated data for building.
     *
     * @return array
     */
    public function getBuildingData(): array
    {
        return [
            'name' => $this->building_name,
            'address' => $this->building_address,
        ];
    }
}
