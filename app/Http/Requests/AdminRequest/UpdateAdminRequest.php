<?php

namespace App\Http\Requests\AdminRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'first_name' => ['sometimes','required', 'string', 'max:255'],
            'last_name' => ['sometimes','required', 'string', 'max:255'],
            'email' => ['sometimes','required', 'string', 'email', 'max:255'],
            'password' => ['sometimes','required', 'string', 'min:8', 'confirmed'],
            'job' => ['sometimes','required', 'string', 'max:255'],
            'phone_number' => ['sometimes','required'],
            'birth_date' =>  ['sometimes','required'],
            'image' => ['sometimes','required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Each image should be jpeg, png, jpg, or gif and maximum 2MB in size
        ];
    }
}
