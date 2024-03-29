<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminProductRequest extends FormRequest
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
            'type_id.required' => ' نوع محصول را انتخاب نمایید!',
            'type_id.exists' => 'یک نوع معتبر را انتخاب نمایید!',
            'status.required' => 'وضعیت محصول را مشخص نمایید',
            'image.required' => 'انتخاب یک تصویر الزامی است! ',
            'image.image' => 'فایل انتخابی باید یک تصویر باشد!',
            'image.mimes' => 'لطفا یک تصویر با پسوندهای روبه رو آپلود نمایید: jpeg, jpg, png, gif',
            'name.required' => 'تکمیل نام اجباری است!',
            'name.min' => 'نام باید حداقل شامل :min کاراکتر باشد!',
            'product_attributes.required' => 'تکمیل اطلاعات برای حداقل یک وزن اجباری است!'
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
            'name' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'type_id' => 'required',
            'status' => 'required',
            'description' => 'required',
            'product_attributes' => 'required'
        ];
    }
}
