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
            'status' => 'string'

        ];
    }
}
