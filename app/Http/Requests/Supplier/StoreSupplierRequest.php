<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'company_name' => 'bail|min:3|required|unique:supplier|max:255',
            'contact_name' => 'min:3|required|max:255',
            'contact_title' => 'min:3|required|max:255',
            'address' => 'min:3|required|max:255',
            'phone' => 'min:3|required|max:255',
            'email' => 'min:3|required|max:255',
            'payment_method' => 'min:3|required|max:255',
            'discount_type' => 'min:3|required|max:255',
            'type_goods' => 'min:3|required|max:255',
            'notes' =>  'min:3|required|max:255',
            'logo' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000',
            'customer_id' => 'integer|required',
            'tier_id' => 'integer|required',
            'city' => 'string|required|min:3',
            'postal_code' => 'string|required|min:3',
            'country' => 'string|required|min:3'
        ];
    }
}
