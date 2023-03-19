<?php

namespace App\Http\Resources;

use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;


class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'post_id' => $this->post_id,
            'title' => $this->title,
            'content' => $this->content,
            'author_id' => $this->author_id,
            'author' => new UserResource($this->whenLoaded('author')),
            'published' => $this->published,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];  
    }
}
