<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'prompt' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'negative_prompt' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'visibility_prompt' => [
                'nullable',
                'string',
            ],
            'steps' => [
                'nullable',
                'string',
                'max:10',
            ],
            'scale' => [
                'nullable',
                'string',
                'max:10',
            ],
            'seed' => [
                'nullable',
                'string',
                'max:100',
            ],
            'sampler' => [
                'nullable',
                'string',
                'max:100',
            ],
            'strength' => [
                'nullable',
                'string',
                'max:10',
            ],
            'noise' => [
                'nullable',
                'string',
                'max:10',
            ],
            'model' => [
                'nullable',
                'string',
                'max:100',
            ],
            'ai_model_id' => [
                'nullable',
                'integer',
            ],
            'description' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'tweet' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
