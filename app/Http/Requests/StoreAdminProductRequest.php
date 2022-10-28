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
            'images.required' => 'انتخاب تصویر اجباری است!',
            'images.max' => 'حداکثر :max تصویر می توانید انتخاب نمایید!',
            'type_id.required' => ' نوع محصول را انتخاب نمایید!',
            'type_id.exists' => 'یک نوع معتبر را انتخاب نمایید!',
            'status.required' => 'وضعیت محصول را مشخص نمایید',
            'images.*.image' => 'فایل انتخابی باید یک تصویر باشد!',
            'images.*.mimes' => 'لطفا یک تصویر با پسوندهای روبه رو آپلود نمایید: jpeg, jpg, png, gif'
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
            'images' => 'required|array|max:3',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif',
            'type_id' => 'required',
            // 'stock' => 'required' // should be handle in store method
            'status' => 'required',
            'description' => 'required'
        ];
    }
}
