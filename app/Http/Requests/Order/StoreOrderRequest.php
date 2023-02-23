<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'customer_id' => 'integer|required',
            'content' => 'text|min:3',
            'type' => 'min:3',
            'status' => 'string',
            'sub_total' => 'numeric',
            'item_discount' => 'numeric',
            'tax' => 'numeric',
            'shipping' => 'numeric',
            'total' => 'numeric',
            'discount' => 'numeric',
            'grand_total' => 'numeric',
            'name' => 'string|min:3',
            'email' => 'string|min:3',
            'phone' => 'string|min:3',
            'address_line' => 'string|min:3',
            'city' => 'string|min:3',
            'postal_code' => 'string|min:3',
            'country' => 'string|min:3',
            'discount_id' => 'integer',
            'order_number' => 'integer|required',
            'payment_id' => 'integer|required',
            'order_date' => 'date|required',
            'payment_date' => 'date',
            'ship_date' => 'date',
            'delivered_date' => 'date',
            'cancel_date' => 'date',
            'return_date' => 'date',
            'return_reason' => 'min:3|required|max:255',
            'shipper_id' => 'integer',
            'freight' => 'min:3|required|max:255',
            'ship_type' => 'integer'
        ];
    }
}
