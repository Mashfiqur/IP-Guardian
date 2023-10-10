<?php

namespace App\Http\Requests\IPAddress;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreIPAddressRequest extends FormRequest
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
            'label'  => [
                'required',
                'string',
                'min:1',
                Rule::unique('ip_addresses')->whereNull('deleted_at'),
            ],
            'ip'  => [
                'required',
                'ip',
                Rule::unique('ip_addresses')->whereNull('deleted_at'),
            ],
            'comment'  => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }
}