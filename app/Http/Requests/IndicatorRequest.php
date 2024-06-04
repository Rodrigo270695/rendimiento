<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndicatorRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('indicators')->ignore($this->indicator ? $this->indicator->id : null),
            ],
            'description' => 'nullable',
        ];
    }
}
