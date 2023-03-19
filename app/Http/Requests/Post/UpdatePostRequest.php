<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'bail|min:3|required|unique:blog_post|max:255',
            'metaTitle' => 'min:3|required|max:255',
            'slug' =>  'min:3|required|unique:blog_post|max:255',
            'summary' => 'min:3|required',
            'content' => 'min:3|required',
            'published' => 'min:3|required|max:255',
            'thumbnail' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000'
        ];
    }
}
