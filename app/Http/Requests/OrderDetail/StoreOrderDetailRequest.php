<?php

namespace App\Http\Requests\OrderDetail;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderDetailRequest extends FormRequest
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
            'product_id' => 'integer|required',
            'order_number' => 'integer',
            'price' => 'decimal|required',
            'quantity' => 'integer|required', 
            'discount' => 'decimal',
            'total' => 'decimal',
            'idsku' => 'min:3|required|max:255',
            'size' => 'min:3|required|max:255',
            'ship_date' => 'date',
            'status' => 'string|required',
            'order_id' => 'integer',
            'delivered_date' => 'date',

         ];
    }
}
