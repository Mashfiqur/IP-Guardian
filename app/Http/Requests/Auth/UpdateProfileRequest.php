<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:1'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')
                    ->whereNull('deleted_at')
                    ->whereNot('id', auth()->id())
            ],
            'password'  => [
                'sometimes',
                'string',
                'confirmed'
            ],
        ];
    }
}