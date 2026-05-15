<?php

namespace App\Http\Requests\products;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'link' => 'required|url',
            'image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp,avif',
                'max:5120',
            ],
            'type' => 'required|string|max:100',
        ];
    }
}
