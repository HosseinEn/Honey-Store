<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminDiscountRequest extends FormRequest
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
            'name.required' => 'تکمیل نام تخفیف اجباری است!',
            'name.unique' => 'این نام قبلا تعریف شده است!',
            'value.required' => 'تکمیل مقدار تخفیف اجباری است! (به درصد وارد نمایید)',
            'value.numeric' => 'مقدار تخفیف باید عددی باشد!'
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
            'name' => 'required|unique:discounts',
            'value' => 'required|numeric|min:0|max:100'
        ];
    }
}
