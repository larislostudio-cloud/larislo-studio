<?php

namespace App\Http\Requests\Social;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content'     => 'required_without:media|string',
            'media'       => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
            'platforms'   => 'required|array|min:1',
            'platforms.*' => 'in:instagram,facebook,tiktok',
            'scheduled_at'=> 'nullable|date',
        ];
    }
}
