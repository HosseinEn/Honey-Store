<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminAttributeRequest extends FormRequest
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
            'weight.unique' => 'این وزن قبلا تعریف شده است!',
            'weight.max' => 'عدد بزرگ‌تر از سقف تعیین شده است (:max)'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'weight' => 'required|numeric|unique:attributes|max:‌99999999999'
        ];
    }
}
