<?php

namespace App\Http\Requests\Discount;
use Illuminate\Support\Facades\Auth;


use Illuminate\Foundation\Http\FormRequest;

class AddDiscountToProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'array'
        ];
    }
}
