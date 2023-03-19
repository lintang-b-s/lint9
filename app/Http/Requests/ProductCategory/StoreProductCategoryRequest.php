<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
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
            'category_name' =>  'min:2|required|unique:product_categories|max:255',
            'description' => 'min:2|required|max:255',
            'picture' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000',
            'active' =>  'min:2|required|max:255',
            'parent_id' => 'integer'
        ];
    }
}
