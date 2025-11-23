<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFishRequest extends FormRequest
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
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

        return [
            'name' => ['required', 'string', 'max:100'],
            'rarity' => ['required', Rule::in($rarities)],
            'base_weight_min' => ['required', 'numeric', 'min:0'],
            'base_weight_max' => ['required', 'numeric', 'gt:base_weight_min'],
            'sell_price_per_kg' => ['required', 'integer', 'min:0'],
            'catch_probability' => ['required', 'numeric', 'between:0.01,100.00'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
        ];
    }
}