<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'sku' => 'min:3|required|max:255',
            'idsku' => 'min:3|required|max:255',
            'product_name' =>'min:3|required|unique:product|max:255',
            'product_description' => 'min:3|required',
            'quantity' => 'integer',
            'unit_price' => 'decimal',
            'size' => 'min:3|required|max:255',
            'discount' => 'decimal',
            'weight' => 'decimal',
            'picture' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000',
            'ranking' => 'integer',
        ];
    }
}
