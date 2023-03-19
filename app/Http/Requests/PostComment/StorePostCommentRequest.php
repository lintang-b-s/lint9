<?php

namespace App\Http\Requests\PostComment;

use Illuminate\Foundation\Http\FormRequest;
// use Dingo\Api\Http\FormRequest;
use App\Models\PostComment;


class StorePostCommentRequest extends FormRequest
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
            'post_id' => 'integer|required',
            'title' => 'min:3|required|unique:post_comments|max:255',
            'content' => 'min:3|required',
            'published' => 'min:3|required|max:255'

        ];
    }
}
