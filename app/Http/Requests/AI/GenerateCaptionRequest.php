<?php

namespace App\Http\Requests\AI;

use Illuminate\Foundation\Http\FormRequest;

class GenerateCaptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'business_type' => 'required|string|max:255',
            'product_name'  => 'required|string|max:255',
            'promo'         => 'nullable|string|max:500',
            'target_market' => 'nullable|string|max:255',
            'tone'          => 'required|in:formal,santai,lucu,profesional,gokil',
        ];
    }
}
