<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'quantity.required' => 'وارد کردن تعداد اجباری است!',
            'quantity.int' => 'لطفا یک عدد را برای تعداد وارد نمایید!',
            'quantity.min' => 'حداقل یک را برای تعداد می توانید وارد نمایید!',
            'attribute_id.required' => 'لطفا یک گزینه از وزن ها را انتخاب نمایید!',
            'attribute_id.exists' => 'یک گزینه معتبر انتخاب نمایید! '
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
            'quantity' => 'required|int|min:1',
            'attribute_id' => 'required|exists:attributes,id'
        ];
    }
}
