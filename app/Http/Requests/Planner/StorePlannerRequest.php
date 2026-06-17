<?php

namespace App\Http\Requests\Planner;

use Illuminate\Foundation\Http\FormRequest;

class StorePlannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'platform'    => 'required|in:instagram,tiktok,facebook,twitter,linkedin',
            'publish_at'  => 'required|date|after_or_equal:now',
            'media'       => 'nullable|file|mimes:jpg,png,mp4,mov|max:10240', // Max 10MB
        ];
    }
}
