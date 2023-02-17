<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BlogPost;

class StorePostRequest extends FormRequest
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
            'title' => 'min:3|required|unique:blog_posts|max:255',
            
            'meta_title' => 'min:3|required|max:255',
            'slug' =>  'min:3|required|unique:blog_posts|max:255',
            'summary' => 'min:3|required',
            'content' => 'min:3|required',
            'published' => 'min:3|required|max:255',
            'thumbnail' => 'image|mimes:jpg,jpeg,png,gif,svg|max:10000'
        ];
    }
}
