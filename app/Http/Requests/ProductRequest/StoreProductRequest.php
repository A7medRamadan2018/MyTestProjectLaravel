<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'quantity' => ['numeric'],
            'category_id' => ['required', 'exists:categories,id'],
            'images' => ['array', 'max:5', 'nullable'], // Maximum 5 images allowed
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Each image should be jpeg, png, jpg, or gif and maximum 2MB in size
        ];
    }
}
