<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminDiscountRequest extends FormRequest
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
        $ignoreDiscount = Discount::findOrFail(substr($this->getRequestUri(), -1))->first()->name;
        // dd($ignoreDiscount);

        return [
            "name" => [
                "required",
                "max:255",
                Rule::unique('discounts')->whereNotIn('name', [$ignoreDiscount]), 
                // Rule::unique('discounts')->ignore($this->id), 
            ],
            "value" => "required"
        ];
    }

        public function messages()
    {
        return [
            'name.required' => 'تکمیل نام تخفیف اجباری است!',
            'name.unique' => 'این نام قبلا تعریف شده است!'
        ];
    }
}
