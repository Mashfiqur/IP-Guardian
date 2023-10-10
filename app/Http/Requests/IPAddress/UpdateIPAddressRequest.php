<?php

namespace App\Http\Requests\IPAddress;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UpdateIPAddressRequest extends FormRequest
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
                Rule::unique('ip_addresses')
                    ->whereNot(config('uuid.column'), Request::instance()->id)
                    ->whereNull('deleted_at'),
            ],
            'comment'  => [
                'sometimes',
                'nullable',
                'string',
            ],
        ];
    }
}