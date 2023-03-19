<?php

namespace App\Http\Requests\UserPayment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPaymentRequest extends FormRequest
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
            'payment_type' => 'string|min:3',
            'provider' =>  'string|min:2',
            'account_no' =>  'string|min:3',
            'expiry' => 'date',
        ];
    }
}
