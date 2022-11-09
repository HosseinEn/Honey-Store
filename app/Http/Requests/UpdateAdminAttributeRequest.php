<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminAttributeRequest extends FormRequest
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

    public function messages()
    {
        return [
            'weight.required' => 'تکمیل وزن اجباری است!',
            'weight.unique' => 'این وزن قبلا تعریف شده است!'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ignoreWeight = Attribute::findOrFail(substr($this->getRequestUri(), -1))->first()->weight;

        return [
            'weight' => [
                'required',
                Rule::unique('attributes')->whereNotIn('weight', [$ignoreWeight]), 
            ]
        ];
    }
}
