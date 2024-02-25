<?php

namespace App\Http\Requests\ProductRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => ['sometimes', 'nullable', 'string'], // Allow optional update
            'description' => ['sometimes', 'nullable', 'string'], // Allow optional update
            'price' => ['sometimes', 'nullable', 'numeric'], // Allow optional update
            'category_id' => ['sometimes', 'nullable', 'exists:categories,id'], // Allow optional update
            'seller_id' => ['sometimes', 'nullable', 'exists:sellers,id'], // Allow optional update
            'quantity' => ['nullable', 'numeric', 'min:0'], // Allow update, non-required, add minimum quantity check
            'is_available' => ['boolean'], // Allow update to boolean field
            'images' => ['nullable', 'array', 'max:5'], // Allow updating images, limit to 5
        ];
    }
}
