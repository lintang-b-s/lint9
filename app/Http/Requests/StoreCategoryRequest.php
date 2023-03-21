<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'title' => 'bail|min:2|required|unique:categories|max:255',
            'meta_title' => 'min:2|required|max:255',
            'slug' => 'min:2|required|unique:categories|max:255',
            'content' => 'min:3|required',
        ];
    }
}
