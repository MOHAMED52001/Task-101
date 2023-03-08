<?php

namespace App\Http\Requests\API\V1\Posts;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'content' => [
                'required',
                'string',
            ],
            'media' => [
                'required',
                'image',
                'max:2048',
                'mimes:png,jpg,jpeg'
            ],
        ];
    }
}
