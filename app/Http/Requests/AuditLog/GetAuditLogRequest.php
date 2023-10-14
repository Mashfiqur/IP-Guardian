<?php

namespace App\Http\Requests\AuditLog;

use App\Enums\AuditLog\AuditLogActionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class GetAuditLogRequest extends FormRequest
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
            'action_type' => [
                'sometimes',
                'array',
            ],
            'action_type.*' => [
                'sometimes',
                'integer',
                new Enum(AuditLogActionTypeEnum::class)
            ],
            'actioned_by'  => [
                'sometimes',
                'array',
            ],
            'actioned_by.*'  => [
                'sometimes',
                'string',
                Rule::exists('users', config('uuid.column'))
            ],
        ];
    }
}