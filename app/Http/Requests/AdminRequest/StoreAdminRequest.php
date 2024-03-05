<?php

namespace App\Http\Requests\AdminRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            // 'name' => ['regex:/^[A-Za-z]+ [A-Za-z]+$/', 'max:50'],
            // 'email' => ['email:rfc,dns', 'unique:admins,email'],
            // 'password' => ['min:8', 'regex:/^(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z\d]).+$/', 'confirmed'],
            // 'job' => ['string', 'max:50'],
            // 'phone_number' => ['numeric', 'digits:11', 'unique:admins,phone_number'],
            // 'birth_date' => ['date_format:Y-m-d'],
            // 'image' => ['image', 'dimensions:max_width=100,max_height=200'],

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'job' => ['required', 'string', 'max:255'],
            'phone_number' => ['required'],
            'birth_date' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Each image should be jpeg, png, jpg, or gif and maximum 2MB in size
        ];
    }
}
