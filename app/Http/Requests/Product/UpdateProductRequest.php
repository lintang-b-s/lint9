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
            
            'product_name' =>'min:3|unique:products|max:255',
            'meta_title' => 'min:3|unique:products|max:255',
            'slug' => 'min:3|unique:products|max:255',
            'product_description' => 'min:3',
            'supplier_id' => 'integer',
            'discount_id' => 'integer',
            'quantity' => 'integer',
            'unit_price' => 'numeric',
            'size' => 'min:3|max:255',
            'weight' => 'numeric',
            'picture' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000',
            'ranking' => 'integer',
            'sold'=> 'integer',
            'review_total' => 'integer',

        ];
    }
}
